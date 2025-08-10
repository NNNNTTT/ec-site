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
        Schema::table('orders', function (Blueprint $table) {
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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('stripe_pi_id');
            $table->dropColumn('stripe_customer_id');
            $table->dropColumn('stripe_yoshin');
            $table->dropColumn('stripe_capture');
            $table->dropColumn('stripe_cancel');
        });
    }
};
