<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            /* Users: 0=>super-admin   , 1=>trucker,  2=>shipper, 3=>broker */
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('otp')->nullable();
            $table->timestamp('otp_expire_at')->nullable();
            $table->string('password');
            $table->tinyInteger('type')->nullable();
            $table->rememberToken();
            $table->string('phone', 255)->nullable();
            $table->string('alt_phone', 255)->nullable();
            $table->foreignId('package_id')->nullable();
            $table->integer('parent_id')->nullable();
            // $table->decimal('subscription_amount')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->boolean('status')->default(1);
            $table->integer('notify_created')->nullable()->comment('0=none, 1=notification, 2=email, 3=both');
            $table->integer('notify_rejected')->nullable()->comment('0=none, 1=notification, 2=email, 3=both');
            $table->integer('notify_withdrawn')->nullable()->comment('0=none, 1=notification, 2=email, 3=both');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
