<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ShipmentsRequest extends Model
{
    protected $guarded = [];
    use HasFactory;


    public function carrier_user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'trucker_id');
    }



    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class, 'shipment_id', 'id');
    }
}
