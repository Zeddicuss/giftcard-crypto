<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'exchange_rate', 'name', 'amount', 'amount_in_naira',
         'pin', 'type', 'photo', 'currency',
          'exchange_rate', 'listed_by', 'category_id', 'status'
    ];

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function image()
    {
        return $this->hasMany(GiftCardImage::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'listed_by');
    }
   
    public function buyer()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
