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
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('transaction_code');
            $table->string('pay')->nullable();
            $table->string('return')->nullable();
            $table->string('purchase_order');
            $table->string('disc_total_rp')->nullable();
            $table->string('disc_total_prc')->nullable();
            $table->string('method');
            $table->string('total_sementara');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
