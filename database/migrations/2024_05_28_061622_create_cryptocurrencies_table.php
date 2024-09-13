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
        Schema::create('cryptocurrencies', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the cryptocurrency (e.g., Bitcoin, Ethereum)
            // $table->string('coin_symbol')->unique(); // Unique ticker symbol (e.g., BTC, ETH)
            $table->decimal('crypto_price', 20, 2)->nullable(); // Market capitalization, nullable
            $table->string('currency')->default('USD');
            $table->decimal('exchange_rate', 10, 2)->nullable(); // Circulating supply, nullable
            // $table->string('exchange_currency')->default('NGN');
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('listed_by');
            $table->enum('v_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('listed_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cryptocurrencies');
    }
};
