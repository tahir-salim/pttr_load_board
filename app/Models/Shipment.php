<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Contact;
use App\Models\ContactGroup;


class Shipment extends Model
{

    // 'WAITING','BOOKED','PENDING','ACCEPTED','DISPATCHED','AT-PICK-UP','AT-DROP-OFF','IN-TRANSIT','DELIVERED','DECLINED','COMPLETE','CANCELED','EXPIRED'


    protected $guarded = [];
    protected $appends = ['is_saved','is_exist_private','is_invoice', 'rating','company_id'];
    use HasFactory;

    /**
     * Get the user that owns the Shipment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getIsSavedAttribute()
    {
        return \DB::table('shipment_saveds')
        ->where('shipment_id', $this->id)
        ->where('trucker_id', auth()->id()) // Authenticated user ki ID match kar rahein
        ->exists();
    }
    
    public function getRatingAttribute()
    {
            $user = $this->user;
            if($user){
                if ($user->parent_id == null) {
                    $rating = $user->company->reviews()->avg('rating');
                    $rating = $rating != null ? $rating : 0;
                    return number_format($rating, 2, '.', '');
                }else{
                    $company =   Company::where('user_id',$user->parent_id)->first();
                    if($company){
                        $rating =  $company->reviews()->avg('rating');
                        $rating =  $rating != null ? $rating : 0;
                        return $rating;
                    }
                }
            }else{
                return $rating = 0;
            }


    }

    public function getCompanyIdAttribute()
    {
            $user = $this->user;
            if($user){
                if($user->parent_id != null){
                    $company =   Company::where('user_id',$user->parent_id)->first();
                    if($company){
                        return (string) $company->id;
                    }
                }else{
                    return (string) $user->company->id;
                }
            }else
            {
                return null;
            }
    }
    
    


    public function getIsInvoiceAttribute()
    {
        return \DB::table('invoices')
        ->where('shipment_id', $this->id)
        ->where('user_id', auth()->id())
        ->exists();
    }

    public function getIsExistPrivateAttribute()
    {
        $contact_groups = [];
        $contacts = Contact::where('trucker_id', auth()->id())->pluck('id')->toArray();
        if (count($contacts) > 0) {
            $contact_groups = ContactGroup::whereIn('contact_id', $contacts)->pluck('group_id')->toArray();
        }

        // Check the logic for determining true or false
        if ($this->is_group == 1) {
            $group_id = unserialize($this->group_id);
            return is_array($group_id) && array_intersect($group_id, $contact_groups);
        } elseif ($this->entire_private_network_id == 1) {
           $contact_Entire = Contact::where('user_id', $this->user_id)->pluck('trucker_id')->toArray();
            if (in_array(auth()->id(), $contact_Entire)) {
                return true;
            }
        }

        return false;

    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function carrier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'trucker_id', 'id');
    }
    public function equipment_type(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class, 'eq_type_id', 'id');
    }
    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class, 'shipment_id', 'id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function shipment_status_trackings(): HasMany
    {
        return $this->hasMany(ShipmentStatusTracking::class, 'shipment_id', 'id');
    }

    public function tracking(): HasOne
    {
        return $this->hasOne(Tracking::class, 'shipment_id', 'id');
    }
    public function trackings(): HasMany
    {
        return $this->hasMany(Tracking::class, 'shipment_id', 'id');
    }
    public function shimpents_requests(): HasMany
    {
        return $this->hasMany(ShipmentsRequest::class, 'shipment_id', 'id')
                    ->orderBy('id', 'desc');
    }

    /**
     * Get all of the Contacts for the Shipment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'user_id', 'user_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
