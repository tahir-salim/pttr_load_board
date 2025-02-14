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
        Schema::create('shipments_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('trucker_id')->nullable();
            $table->integer('shipment_id')->nullable();
            $table->double('amount', 14,2)->nullable();
            $table->integer('status')->nullable()->comment('0 = decline  | 1 = accept');
            $table->integer('type')->nullable()->comment('0 = is_private  | 1 = is_loardboard');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments_requests');
    }
};
