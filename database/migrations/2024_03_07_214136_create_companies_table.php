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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('type', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('dot', 255)->nullable();
            $table->bigInteger('mc')->nullable();
            $table->integer('zip_code')->nullable();
            $table->longText('address')->nullable();
            $table->bigInteger('user_id')->nullable();
            // $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
