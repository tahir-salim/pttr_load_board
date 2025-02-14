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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('email', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('company_name', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('zip_code', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('ext', 255)->nullable();
            $table->string('affiliat', 255)->nullable();
            $table->string('legal_mc_number', 255)->nullable();
            $table->string('legal_power_units', 255)->nullable();
            $table->string('legal_drivers', 255)->nullable();
            $table->string('safety_rating', 255)->nullable();
            $table->string('legal_dot_number', 255)->nullable();
            $table->string('legal_us_state', 255)->nullable();
            $table->string('legal_us_number', 255)->nullable();
            $table->string('legal_canadian_authority_number', 255)->nullable();
            $table->string('trucker_id', 255)->nullable();
            $table->string('user_id', 255)->nullable();
            $table->string('group_id', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
