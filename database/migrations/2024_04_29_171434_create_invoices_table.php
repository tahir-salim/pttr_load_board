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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('customer')->nullable();
            $table->string('email')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('po_no')->nullable();
            $table->timestamp('shipping_date')->nullable();
            $table->timestamp('delivery_date')->nullable();
            $table->decimal('invoice_amount')->nullable();
            $table->integer('total_miles')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
