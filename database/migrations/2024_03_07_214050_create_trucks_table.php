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
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->string('origin')->nullable();
            $table->string('origin_place_id')->nullable();
            $table->string('destination')->nullable();
            $table->string('destination_place_id')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->time('from_time')->nullable();
            $table->time('to_time')->nullable();
            $table->string('equipment_detail')->nullable()->comment('0 = full | 1 = partial');
            $table->integer('eq_type_id')->nullable();
            $table->string('eq_name')->nullable();
            $table->string('length')->nullable();
            $table->string('weight')->nullable();
            $table->string('commodity')->nullable();
            $table->string('reference_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->decimal('rate')->nullable();
            $table->integer('status_phone')->comment('0 = off | 1 = on')->default(0)->nullable();
            $table->integer('status_email')->comment('0 = off | 1 = on')->default(0)->nullable();
            $table->integer('is_posted')->comment('0 = off | 1 = on')->default(0)->nullable();
            $table->enum('truck_status', ['available','pending', 'pickup', 'drop off', 'in transit', 'delivered', 'decline', 'Accepted'])->default('available');
            $table->integer('bid')->comment('0 = no | 1 = yes')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};
