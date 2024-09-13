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
        Schema::create('gift_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('amount', 10, 2); // Gift card value
            $table->decimal('amount_in_naira', 10, 2);
            $table->string('pin')->nullable();
            $table->enum('type', ['physical', 'e-code']);
            $table->string('currency', 3)->default('USD');
            $table->string('photo')->nullable();
            $table->decimal('exchange_rate', 10, 2);
            $table->unsignedBigInteger('listed_by'); // Foreign key to users table (who listed the card)
            $table->unsignedBigInteger('category_id');
            $table->enum('status', ['available', 'sold', 'expired'])->default('available'); // Gift card status
            $table->enum('v_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('listed_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_cards');
    }
};
