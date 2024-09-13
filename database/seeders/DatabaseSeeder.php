<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\CryptoPrice;
use App\Models\Cryptocurrency;
use App\Models\CryptoTransaction;
use App\Models\Giftcard;
use App\Models\Wallet;
use App\models\Order;
use App\Models\OrderHistory;
use App\Models\Transaction;
use App\Models\Setting;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    { 
        User::factory()->count(4)->create();
        // CryptoPrice::factory()->count(2)->create();
        // Giftcard::factory()->count(2)->create(); 
        // Cryptocurrency::factory()->count(2)->create();
        // CryptoTransaction::factory()->count(2)->create();
        // Wallet::factory()->count(2)->create();
        // Order::factory()->count(2)->create();
        // Transaction::factory()->count(2)->create();
        // Setting::factory()->count(2)->create();
    }
}
