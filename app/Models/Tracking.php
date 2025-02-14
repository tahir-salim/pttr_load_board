<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tracking extends Model
{
    protected $guarded = [];

    use HasFactory;

    /**
     * Get all of the comments for the Tracking
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tracking_details(): HasMany
    {
          return $this->hasMany(TrackingDetail::class, 'tracking_id', 'id')->orderBy('sort_no', 'ASC');
    }
    public function tracking_details_ASC(): HasMany
    {
          return $this->hasMany(TrackingDetail::class, 'tracking_id', 'id')->orderBy('sort_no', 'ASC');
    }

    public function shipments(): BelongsTo
    {
        return $this->belongsTo(Shipment::class, 'shipment_id', 'id');
    }

}
