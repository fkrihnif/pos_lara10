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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->references('id')->on('category')->onDelete('cascade');
            $table->foreignId('category_item_id')->references('id')->on('category_item')->onDelete('cascade');
            $table->string('product_code')->unique();
            $table->string('name');
            $table->string('quantity');
            $table->string('price');
            $table->string('capital_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
