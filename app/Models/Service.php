<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'name',
        'image',
        'category_id',
        'price',
        'duration',
        'description',
        'business_id',
        'created_by',
        'is_free',
        'allow_partial_payment',
        'partial_payment_amount'
    ];

    protected $casts = [
        'allow_partial_payment' => 'boolean',
        'partial_payment_amount' => 'decimal:2',
        'is_free' => 'boolean'
    ];

    public function Category()
    {
        return $this->hasOne(category::class, 'id', 'category_id');
    }

    // Service belongs to Business
    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    // Service can have many appointments (if needed)
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'service_id');
    }

    /**
     * Calculate partial payment amount (deposit)
     */
    public function getPartialPaymentAmount()
    {
        if (!$this->allow_partial_payment || !$this->partial_payment_amount) {
            return floatval($this->price);
        }

        return floatval($this->partial_payment_amount);
    }

    /**
     * Get remaining amount after partial payment
     */
    public function getRemainingAmount()
    {
        if (!$this->allow_partial_payment || !$this->partial_payment_amount) {
            return 0;
        }

        return floatval($this->price) - floatval($this->partial_payment_amount);
    }

    /**
     * Check if service has different partial and full amounts
     */
    public function hasPartialPaymentOption()
    {
        return $this->allow_partial_payment && 
               $this->partial_payment_amount && 
               floatval($this->partial_payment_amount) < floatval($this->price);
    }
}
