<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'withdrawals';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'amount',
        'withdraw_from',
        'transfer_from',
        'method',
        'status',
        'details',
        'description',
        'receiver_email',
    ];

    /**
     * Get the user that owns the withdrawal.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
