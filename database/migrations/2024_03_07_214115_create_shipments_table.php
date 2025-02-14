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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->integer('miles')->nullable();
            $table->string('duration')->nullable();
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
            $table->integer('company_id')->nullable();
            $table->integer('status_phone')->default(0)->comment('0 = off | 1 = on');
            $table->integer('status_email')->default(0)->comment('0 = off | 1 = on');
            $table->integer('is_tracking')->default(0)->comment('0 = no | 1 = yes');
            $table->integer('tracking_id')->nullable();
            $table->integer('is_private_network')->default(0)->comment('0 = no | 1 = yes');
            $table->integer('is_public_load')->default(0)->comment('0 = no | 1 = yes');
            $table->string('entire_private_network_id')->nullable();
            $table->integer('is_group')->default(0)->comment('0 = no | 1 = yes');
            $table->string('group_id')->nullable();
            $table->integer('is_allow_carrier_to_book_now')->default(0)->comment('0 = no | 1 = yes');
            $table->decimal('dat_rate')->nullable();
            $table->decimal('private_rate')->nullable();
            $table->integer('is_allow_bids')->default(0)->comment('0 = no | 1 = yes')->nullable();
            $table->integer('max_bid_rate')->nullable();
            $table->string('status')->nullable()->comment('1. WAITING 2. BOOKED 3. WITH BIDS 4. PENDING 5. ACCEPTED 6. DISPATCHED 7. AT PICK UP 8. AT DROP OFF 9. IN TRANSIT 10. DELIVERED 11. DECLINED 12. COMPLETE 13. CANCELED');
            $table->integer('is_post')->default(1)->comment('0 = Un-Post | 1 = Posted');
            $table->decimal('booking_rate',14,2)->default(0)->nullable();
            $table->integer('trucker_id')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
