<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Truck extends Model
{
    use HasFactory;


    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function getWeightAttribute()
    {
       return $this->attributes['weight'] == 0 ? ' None ' : $this->attributes['weight'];
    }



    public function equipment_type(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class, 'eq_type_id', 'id');
    }

    public function truck_posts(): HasMany
    {
        return $this->hasMany(TruckPost::class, 'truck_id', 'id');
    }
}
