<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'contact_groups');
    }

}
