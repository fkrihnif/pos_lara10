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
        Schema::table('product_transaction', function (Blueprint $table) {
            $table->string('price')->nullable();
            $table->string('capital_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_transaction', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('capital_price');
        });
    }
};
