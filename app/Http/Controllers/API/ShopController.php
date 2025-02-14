<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    public function shopList()
    {
        
        if(request()->get('id') != null){
            $allShops = Shop::find(request()->get('id'));
            if(!$allShops){
                 return $this->formatResponse(
                    'success',
                    'Record not Found',
                    $allShops,
                    200
                 );
            }
            $allShops->image = asset($allShops->image);
            $allShops->description = strip_tags($allShops->description); 
            $allShops->status = $allShops->status == "1" ? 'Active' : 'In-Active'  ; 
            return $this->formatResponse(
            'success',
            'Record fetch Successfully',
            $allShops,
            200
            );
        }
        $allShops = Shop::where('status',1)->paginate(10);
        if(count($allShops) > 0){
          $allShops->transform(function ($all_shop) {
                $all_shop['image'] = asset($all_shop->image);
                $all_shop['description'] = strip_tags($all_shop->description); 
                $all_shop['status'] = $all_shop->status == "1" ? 'Active' : 'In-Active'  ; 
              return $all_shop;
          });
            return $this->formatResponse(
                'success',
                'Record fetch Successfully',
                $allShops,
                200
            );
        }else{
             return $this->formatResponse(
                'success',
                'No Record Found',
                $allShops,
                200
            );
        }
    }
}
