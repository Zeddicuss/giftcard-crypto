<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    use HasFactory;

    protected $fillable = ['currency', 'symbol', 'exchange_rate', 'exchange_currency', 'exchange_symbol'];
}
