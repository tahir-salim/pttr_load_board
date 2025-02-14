<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{

    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;
     protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'email_verified_at',
        'phone',
        'package_id',
        'parent_id',
        'expired_at',
        'device_token'.
        'session_token'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array

     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array

     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Interact with the user's first name.
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */

    /**
     * Get the company associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'user_id');
    }
    
    
    public function parentUser(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'parent_id');
    }

    public function onboardingProfile(): HasOne
    {
        return $this->hasOne(OnboardingProfile::class, 'user_id');
    }

    protected function type(): Attribute
    {
        return new Attribute(
            /* Users: 0=>super-admin   , 1=>trucker,  2=>shipper, 3=>broker 4=>both */
            get: fn($value) => ["super-admin", "trucker", "shipper", "broker" , "combo"][$value],
        );
    }

    public function recentSearch(): HasMany
    {
        return $this->hasMany(RecentSearch::class);
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function trucks(): HasMany
    {
        return $this->hasMany(Truck::class);
    }
}
