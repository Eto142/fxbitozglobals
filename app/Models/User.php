<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'account_type',
        'name',
        'phone',
        'country',
        'date_of_birth',
        'role',
        'status',
        'bank_name',
        'currency_symbol',
        'account_name',
        'account_number',
        'swift_code',
        'btc_address',
        'eth_address',
        'ltc_address',
        'email',
        'id_card',
        'passport',
        'kyc_status',
        'address',
        'user_address',
        'dob',
        'employment_status',
        'third_username',
        'third_user_address',
        'third_dob',
        'third_employment_status',
        'third_country',
        'third_phone',
        'third_name',
        'third_address',
        'referred_by',
        'email_verified_at',
        'password',
        'can_deposit',
        'can_withdraw',
        'can_intra_transfer',
        'can_access_plans',
        'can_access_stocks',
        'can_access_trade',
        'can_access_transactions',
        'can_access_settings',
        'can_access_other',
        'deposit_email_alert',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'can_deposit' => 'boolean',
            'can_withdraw' => 'boolean',
            'can_intra_transfer' => 'boolean',
            'can_access_plans' => 'boolean',
            'can_access_stocks' => 'boolean',
            'can_access_trade' => 'boolean',
            'can_access_transactions' => 'boolean',
            'can_access_settings' => 'boolean',
            'can_access_other' => 'boolean',
            'deposit_email_alert' => 'boolean',
        ];
    }


    // app/Models/User.php
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    // Generating a unique referral code
    public function generateReferralCode()
    {
        $this->referral_code = strtoupper(substr(md5(uniqid()), 0, 8));
        $this->save();
    }


    public function accountBalance()
    {
        return $this->hasOne(AccountBalance::class);
    }


// Profit relationship
    public function profit(): HasMany
    {
        return $this->hasMany(Profit::class);
    }

    // public function deposit()
    // {
    //     return $this->hasMany(Deposit::class);
    // }
    
    
    public function deposits()
{
    return $this->hasMany(Deposit::class, 'user_id');
}

    
    

    public function trade()
    {
        return $this->hasOne(TradeHistory::class, 'user_id');
    }

    public function withdrawal()
    {
        return $this->hasOne(Withdrawal::class, 'user_id');
    }
    
    
     // Automatically set default permissions when creating a new user
    protected static function booted()
    {
        static::creating(function ($user) {
            if (is_null($user->can_deposit)) $user->can_deposit = true;
            if (is_null($user->can_withdraw)) $user->can_withdraw = true;
            if (is_null($user->can_intra_transfer)) $user->can_intra_transfer = true;
        });
    }
}
