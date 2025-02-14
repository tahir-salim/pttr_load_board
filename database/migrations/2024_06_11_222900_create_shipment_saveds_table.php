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
        Schema::create('shipment_saveds', function (Blueprint $table) {
            $table->id();
            $table->integer('trucker_id')->nullable();
            $table->integer('shipment_id')->nullable();
            $table->integer('status')->nullable()->comment('0- unsaved 1 = saved	');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_saveds');
    }
};
