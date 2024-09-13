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
        Schema::create('crypto_wallet_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('crypto_name');
            $table->string('wallet_address')->unique();
            $table->string('wallet_provider')->nullable();
            $table->unsignedBigInteger('crypto_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('crypto_id')->references('id')->on('add_crypto')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crypto_wallet_addresses');
    }
};
