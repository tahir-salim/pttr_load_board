<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TruckPost extends Model
{
    protected $guarded = [];
    protected $appends = ['rating'];
    use HasFactory;

     public function getRatingAttribute()
        {
           
                $user_parent = $this->trucks->user->parent_id;
                // dd($user_parent);
                if ($user_parent == null) {
    
                      $rating = $this->trucks->user->company->reviews()->avg('rating');
                    $rating = $rating != null ? $rating : 0;
                    return number_format($rating, 2, '.', '');
                }else{
                     $company =   Company::where('user_id',$this->trucks->user->parent_id)->first();
                     if($company){
                        return $company->reviews()->avg('rating');
                    }
                }
        }
    
    

    public function trucks(): BelongsTo
    {
        return $this->belongsTo(Truck::class, 'truck_id', 'id');
    }
    
    // public function truck(): HasOne
    // {
    //     return $this->hasOne(Truck::class, 'truck_id', 'id');
    // }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function truck_post_states(): HasMany
    {
        return $this->hasMany(TruckPostDestState::class, 'truck_post_id', 'id');
    }

}
