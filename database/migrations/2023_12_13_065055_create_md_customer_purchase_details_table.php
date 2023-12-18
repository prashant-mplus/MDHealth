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
        Schema::create('md_customer_purchase_details', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable();
            $table->bigInteger('customer_id')->nullable();
            $table->bigInteger('package_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('package_treatment_price')->nullable();
            $table->string('package_hotel_price')->nullable();
            $table->string('package_transportation_price')->nullable();
            $table->string('package_total_price')->nullable();
            $table->string('treatment_start_date')->nullable();

            $table->string('package_payment_plan')->nullable();

            $table->enum('purchase_type', ['pending','in_progress','active', 'completed', 'cancelled'])->nullable();
            $table->enum('payment_method', ['card', 'bank', 'md_coin'])->nullable();
            $table->enum('platform_type', ['android', 'ios', 'web'])->nullable();
            $table->string('created_ip_address')->nullable();
            $table->string('modified_ip_address')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('modified_by')->nullable();
            $table->enum('status', ['active', 'delete', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('md_customer_purchase_details');
    }
};
