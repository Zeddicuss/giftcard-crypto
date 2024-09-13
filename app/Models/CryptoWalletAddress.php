<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptoWalletAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'crypto_name', 'wallet_address', 'wallet_provider', 'user_id', 'crypto_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addcrypto()
    {
        return $this->belongsTo(AddCrypto::class);
    }

    public function cryptocurrency()
    {
        return $this->belongsTo(Cryptocurrency::class, 'crypto_id');
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }


}
