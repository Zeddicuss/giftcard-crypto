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
        Schema::create('crypto_prices', function (Blueprint $table) {
            $table->id();
            $table->string('crypto_name'); // Name of the cryptocurrency (e.g., Bitcoin)
            $table->string('symbol'); // Symbol of the cryptocurrency (e.g., BTC)
            $table->decimal('price', 20, 8); // Price of the cryptocurrency with high precision
            $table->string('currency', 3)->default('USD'); // Currency in which the price is denominated
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crypto_prices');
    }
};
