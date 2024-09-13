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
        Schema::create('crypto_rates', function(Blueprint $table){
            $table->id();
            $table->string('crypto');
            $table->string('symbol');
            $table->decimal('exchange_rate', 20, 2);
            $table->string('exchange_crypto');
            $table->string('exchange_symbol');
            $table->timestamps();
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
