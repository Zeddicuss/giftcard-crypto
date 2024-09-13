<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddCrypto extends Model
{
    use HasFactory;

    
    protected $table = 'add_crypto';
    
    protected $fillable = [
        'name', 'symbol', 'status'
    ];

    public function cryptoWalletAddress()
    {
        return $this->hasMany(CryptoWalletAddress::class, 'crypto_id');
    }

    public function crypto()
    {
        return $this->hasMany(Cryptocurrency::class);
    }
}
