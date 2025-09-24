<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Notifiable;

    protected $fillable = [
    'first_name',
    'last_name',
    'phone',
    'email',
    'password',
    'is_admin',
    'referral_code',
    'referred_by',
    'balance',
    'last_ad_view'
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'last_ad_view' => 'datetime',
        'is_admin' => 'boolean',
    ];

    /**
     * Relationship to referred users
     */
    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by', 'referral_code');
    }

    /**
     * Relationship to transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Relationship to ad views
     */
    public function adViews()
    {
        return $this->hasMany(AdView::class);
    }

    /**
     * Relationship to withdrawals
     */
    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function getTotalCoinsEarnedFromAsAttribute()
    {
        return $this->adViews()->sum('earned_coins');
    }

    public function isAdmin(): bool
{
    return (bool) $this->is_admin;
}




}