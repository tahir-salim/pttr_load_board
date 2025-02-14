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
        Schema::create('tracking_details', function (Blueprint $table) {
            $table->id();
            $table->string('street_address')->nullable();
            $table->string('street_place_id')->nullable();
            $table->string('street_addressLat')->nullable();
            $table->string('street_addressLng')->nullable();
            $table->string('appointment_date')->nullable();
            $table->string('dock_info')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('lcoation_name')->nullable();
            $table->string('tracking_start_time')->nullable();
            $table->string('notes')->nullable();
            $table->integer('type')->default(0)->nullable()->comment('0 = Pickup 1 = Dropoff');
            $table->bigInteger('tracking_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_details');
    }
};
