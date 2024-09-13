<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use App\Notifications\VerifyEmail;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
            'firstname', 'lastname', 'email', 'password',
            'date_of_birth',
            'address',
            'gender',
            'email',
            'email_verified_at',
            'password',
            'phone',
            'verification_status',
            'photo',
            'role',
            'is_active',
            'wallet_address',
            'wallet_picture',
            'wallet_name',
            'bank_name',
            'account_number',
            'account_name',
            'verification_token',
            'is_verified',
            '2fa_enabled'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin()
{
    return $this->role === 'admin';
}

    public function wallet()
    {
        return $this->hasMany(Wallet::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function crypto()
    {
        return $this->hasMany(Cryptocurrency::class);
    }

    public function giftcard()
    {
        return $this->hasMany(GiftCard::class);
    }

    public function cryptotransactions()
    {
        return $this->hasMany(CryptoTransaction::class);
    }

    public function ticket()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function cryptoWalletAddress()
    {
        return $this->hasMany(CryptoWalletAddress::class, 'user_id');
    }

    
}
