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
        Schema::create('service_category_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->nullable();
            $table->foreignId('service_category_id')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_category_items');
    }
};
