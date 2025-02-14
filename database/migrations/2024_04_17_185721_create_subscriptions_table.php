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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('package_id')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('customer_profile_id')->nullable();
            $table->string('subscription_id')->nullable();
            $table->longText('transaction_detail')->nullable();
            $table->decimal('amount')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->boolean('is_active')->default(0)->comment('active = 1,inactive = 0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
