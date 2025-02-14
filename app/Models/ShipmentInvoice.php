<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShipmentInvoice extends Model
{   
    protected $guarded = [];
    use HasFactory;
    
    
     public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function carrier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'trucker_id', 'id');
    }
    
    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class, 'shipment_id', 'id');
    }
}
