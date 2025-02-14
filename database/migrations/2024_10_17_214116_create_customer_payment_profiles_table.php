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
        Schema::create('customer_payment_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_profile_id');
            $table->string('customer_payment_profile_id')->nullable();
            $table->boolean('live_mode')->comment('1=>active, 0=>inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_payment_profiles');
    }
};
