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
        Schema::create('recent_searches', function (Blueprint $table) {
            $table->id();
            $table->string('origin')->nullable();
            $table->string('destination')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->string('equipment_detail')->nullable()->comment('0 = full | 1 = partial');
            $table->string('eq_type_id')->nullable();
            $table->string('eq_name')->nullable();
            $table->string('length')->nullable();
            $table->string('weight')->nullable();
            $table->foreignId('user_id');
            $table->integer('bid')->comment('0 = no | 1 = yes')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recent_searches');
    }
};
