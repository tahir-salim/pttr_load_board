<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_id',
        'package_id',
        'invoice_no',
        'transaction_id',
        'subscription_id',
        'subscription_detail',
        'transaction_detail',
        'expired_at',
        'amount',
        'is_active',
        'customer_payment_profile_id',
        'customer_profile_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, );
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, );
    }
}
