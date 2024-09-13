<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;  

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); 
            $table->unsignedBigInteger('buyer'); 
            $table->string('buyer_name')->nullable();
            $table->unsignedBigInteger('seller');
            $table->string('seller_name')->nullable();
            $table->unsignedBigInteger('crypto_id')->nullable();
            $table->unsignedBigInteger('giftcard_id')->nullable();
            $table->string('wallet_address')->nullable();
            $table->string('network')->nullable();
            $table->enum('order_type', ['crypto', 'giftcard']);
            $table->decimal('amount_in_usd', 20, 2);
            $table->decimal('exchange_rate', 20, 2);
            $table->decimal('amount_in_naira', 20, 2); // Price per unit of the product
            $table->string('photo')->nullable();
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending'); // Status of the order
            $table->timestamps();


            // Foreign key constraints with unique descriptive names
            $table->foreign('buyer')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');  // Unique constraint name

                $table->foreign('seller')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');  // Unique constraint name

            $table->foreign('giftcard_id')
                ->references('id')
                ->on('gift_cards')
                ->onDelete('cascade');  // Unique name

            $table->foreign('crypto_id')
                ->references('id')
                ->on('cryptocurrencies')
                ->onDelete('cascade');  // Unique name

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
