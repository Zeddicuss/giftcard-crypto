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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->unique(); // Unique transaction number
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->string('name'); // Type of product (e.g., App\Models\Giftcard, App\Models\CryptoTransaction)
            $table->unsignedBigInteger('product_id'); // Foreign key to product (giftcard or crypto transaction)
            $table->string('brand'); // Amount of the transaction
            $table->decimal('exchange_rate', 10, 2);
            $table->enum('transaction_type', ['buy', 'sell', 'transfer'])->default('buy'); // Type of transaction
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending'); // Status of the transaction
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('gift_cards')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
