<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddGiftcard extends Model
{
    use HasFactory;

    protected $table = 'add_giftcard';
    protected $fillable =[
        'brand', 'name', 'min_amount', 'max_amount', 'currency', 'status'

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public $timestamps = true;
}
