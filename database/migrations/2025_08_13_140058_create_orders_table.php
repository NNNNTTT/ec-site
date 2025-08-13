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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('orders_user_id_foreign');
            $table->string('status')->default('pending');
            $table->integer('total_price');
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('unpaid');
            $table->string('shipping_name');
            $table->string('shipping_postcode');
            $table->string('shipping_prefecture');
            $table->string('shipping_address');
            $table->string('shipping_phone');
            $table->timestamps();
            $table->string('stripe_pi_id')->nullable();
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_yoshin')->nullable();
            $table->string('stripe_capture')->nullable();
            $table->string('stripe_cancel')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
