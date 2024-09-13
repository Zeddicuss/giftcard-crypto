<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptoTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number',
        'crypto_price',
        'transaction_type',
        'user_id',
        'product_id',
        'crypto_name',
        'wallet_address',
        'status',
    ];

    public function orders()
    {
        return $this->morphMany(Order::class, 'product');
    }

    public function cryptocurrency()
    {
        return $this->belongsTo(Cryptocurrency::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
