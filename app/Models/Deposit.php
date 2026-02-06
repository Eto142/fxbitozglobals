<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // make sure this is imported

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'deposit_type',
        'payment_mode',
        'proof',
        'bank_name',
        'account_name',
        'account_number',
        'status',
        'payer_name',
        'description',
    ];

    /**
     * Relationship: Each deposit belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
