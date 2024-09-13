<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cryptocurrency extends Model
{
    use HasFactory;

    protected $fillable = [ 'name', 
    'coin_symbol',
    'crypto_price',
    'exchange_rate',
    'photo',
    'listed_by'];
    public function cryptoPrices()
    {
        return $this->hasMany(CryptoPrice::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'buyer_id');

    }

    public function cryptotransaction()
    {
        return $this->hasMany(CryptoTransaction::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'listed_by');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'listed_by');
    }

    public function addcrypto()
    {
        return $this->belongsTo(AddCrypto::class, 'crypto_id');
    }

}
