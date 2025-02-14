<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    public function serviceCategories(): HasMany
    {
        return $this->hasMany(ServiceCategory::class, 'service_id', 'id');
    }

    public function serviceCategoryItem(): HasMany
    {
        return $this->hasMany(ServiceCategoryItem::class, 'service_id', 'id');
    }
}
