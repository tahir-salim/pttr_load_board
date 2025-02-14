<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrackingDetail extends Model
{
    protected $guarded = [];
     use HasFactory;
     
      public function trackings(): BelongsTo
    {
        return $this->belongsTo(Tracking::class, 'tracking_id', 'id');
    }
}
