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
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('address');
            $table->string('delivery_fee');
            // $table->unsignedBigInteger('product_id');
            // $table->unsignedBigInteger('quantity');
            // $table->unsignedBigInteger('unit_price');
            // $table->unsignedBigInteger('total_price');
            $table->unsignedBigInteger('sub_total');
            $table->unsignedBigInteger('grand_total');
            $table->string('status');
            $table->timestamps();
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
