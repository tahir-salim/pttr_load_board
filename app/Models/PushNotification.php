<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PushNotification extends Model
{
    protected  $guarded = [];
    use HasFactory;
    
    public function shipments(): BelongsTo
    {
        return $this->belongsTo(Shipment::class, 'type_id', 'id');
    }

}
