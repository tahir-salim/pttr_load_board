<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_groups');
    }
}
