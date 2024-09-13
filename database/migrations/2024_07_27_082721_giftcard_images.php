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
        Schema::create('giftcard_images', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable(); // Path to the stored image
            $table->unsignedBigInteger('gift_card_id');
            $table->timestamps();
        
            // Foreign key constraint
            $table->foreign('gift_card_id')->references('id')->on('gift_cards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
