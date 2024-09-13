<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'seller',
        'buyer',
        'order_type',
        'crypto_id',
        'giftcard_id',
        'wallet_address_id',
        'amount_in_usd',
        'amount_in_naira',
        'exchange_rate',
        'status'
    ];


    public function seller()
    {
        return $this->belongsTo(User::class, 'seller');
    }
    
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer');
    }

    public function crypto()
    {
        return $this->belongsTo(Cryptocurrency::class, 'crypto_id');
    }

    public function giftcard()
    {
        return $this->belongsTo(Giftcard::class, 'giftcard_id');
    }

    public function orderHistory()
    {
        return $this->hasMany(OrderHistory::class);
    }

    public function cryptoWalletAddress()
    {
        return $this->belongsTo(CryptoWalletAddress::class);
    }
}
