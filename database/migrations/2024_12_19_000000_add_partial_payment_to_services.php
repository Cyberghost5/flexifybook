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
            if (!Schema::hasColumn('services', 'allow_partial_payment')) {
                $table->boolean('allow_partial_payment')->default(false)->after('is_free');
            }
            if (!Schema::hasColumn('services', 'partial_payment_type')) {
                $table->enum('partial_payment_type', ['percentage', 'fixed'])->default('percentage')->after('allow_partial_payment');
            }
            if (!Schema::hasColumn('services', 'partial_payment_amount')) {
                $table->decimal('partial_payment_amount', 10, 2)->nullable()->after('partial_payment_type');
            }
            if (!Schema::hasColumn('services', 'minimum_payment_required')) {
                $table->boolean('minimum_payment_required')->default(false)->after('partial_payment_amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'allow_partial_payment')) {
                $table->dropColumn('allow_partial_payment');
            }
            if (Schema::hasColumn('services', 'partial_payment_type')) {
                $table->dropColumn('partial_payment_type');
            }
            if (Schema::hasColumn('services', 'partial_payment_amount')) {
                $table->dropColumn('partial_payment_amount');
            }
            if (Schema::hasColumn('services', 'minimum_payment_required')) {
                $table->dropColumn('minimum_payment_required');
            }
        });
    }
};