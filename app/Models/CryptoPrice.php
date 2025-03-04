<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptoPrice extends Model
{
    use HasFactory;

    public function cryptocurrency()
    {
        return $this->belongsTo(Cryptocurrency::class, 'crypto_type', 'type');
    }
}
