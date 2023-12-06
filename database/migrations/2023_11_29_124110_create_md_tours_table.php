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
        Schema::create('md_tours', function (Blueprint $table) {
            $table->id();
            $table->string('tour_name')->nullable();
            $table->longText('tour_description')->nullable();
            $table->string('tour_days')->nullable();
            $table->string('tour_image_path')->nullable();
            $table->string('tour_image_name')->nullable();
            $table->string('tour_price')->nullable();
            $table->string('tour_other_services')->nullable();
            $table->enum('platform_type', ['android', 'ios', 'web'])->nullable();
            $table->enum('status', ['active', 'delete', 'inactive'])->default('active');
            $table->string('created_ip_address')->nullable();
            $table->string('modified_ip_address')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('modified_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('md_tours');
    }
};
