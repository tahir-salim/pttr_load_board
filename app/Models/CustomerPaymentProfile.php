<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPaymentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'live_mode',
    ];
}
