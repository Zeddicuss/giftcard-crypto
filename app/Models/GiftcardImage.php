<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftcardImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo', 'gift_card_id'

    ];

    public function giftcard()
    {
        return $this->belongsTo(GiftCard::class);
    }
}
