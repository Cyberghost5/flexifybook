<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Remove unnecessary columns if they exist
            if (Schema::hasColumn('services', 'partial_payment_type')) {
                $table->dropColumn('partial_payment_type');
            }
            if (Schema::hasColumn('services', 'minimum_payment_required')) {
                $table->dropColumn('minimum_payment_required');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->enum('partial_payment_type', ['percentage', 'fixed'])->default('fixed')->after('allow_partial_payment');
            $table->boolean('minimum_payment_required')->default(false)->after('partial_payment_amount');
        });
    }
};