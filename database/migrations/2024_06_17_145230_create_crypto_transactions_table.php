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
        Schema::create('crypto_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->unique();
            $table->decimal('crypto_price', 20, 8); // Amount of crypto, with high precision
            $table->enum('transaction_type', ['buy', 'sell', 'transfer'])->default('buy'); // Type of transaction
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->unsignedBigInteger('product_id');
            $table->string('crypto_name'); // Type of cryptocurrency
            $table->string('wallet_address'); // Wallet address involved in the transaction
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending'); // Status of the transaction
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('cryptocurrencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crypto_transactions');
    }
};
