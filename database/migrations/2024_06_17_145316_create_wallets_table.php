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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->string('crypto_type')->nullable(); // Type of cryptocurrency, e.g., BTC, ETH
            $table->string('wallet_address')->unique()->nullable(); // Unique wallet address, nullable for fiat only wallets
            $table->decimal('crypto_balance', 20, 8)->default(0); // Crypto balance with high precision
            $table->string('fiat_currency', 3)->nullable(); // Fiat currency type, e.g., USD, EUR
            $table->decimal('fiat_balance', 20, 2)->default(0); // Fiat balance with two decimal precision
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
