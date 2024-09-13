<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number',
        'user_id',
        'name',
        'product_id',
        'brand',
        'exchange_rate',
        'transaction_type',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function giftcard()
    {
        return $this->belongsTo(GiftCard::class, 'giftcard_id');
    }
}
