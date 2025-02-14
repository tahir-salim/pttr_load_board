<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceCategoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'service_category_id',
        'lat',
        'lng',
        'is_active',
        'icon',
        'street_address',
        'street_place_id',

    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function serviceCategory(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id', 'id');
    }
}
