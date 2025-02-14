<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TruckPostDestState extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function truck_post(): BelongsTo
    {
        return $this->belongsTo(TruckPost::class, 'truck_post_id','id');
    }

}
