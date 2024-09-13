<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo_path'];

    public function giftcards()
    {
        return $this->hasMany(GiftCard::class);
    }

    public function addgiftcards()
    {
        return $this->hasMany(AddGiftcard::class);
    }
}
