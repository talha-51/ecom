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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cat_id');
            $table->unsignedBigInteger('sub_id');
            $table->unsignedBigInteger('brand_id');
            $table->string('name');
            $table->string('price');
            $table->integer('quantity');
            $table->string('image');
            $table->integer('added_by_id')->nullable();
            $table->integer('updated_by_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
