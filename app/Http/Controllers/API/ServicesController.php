<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceCategoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller
{
    public function servicesList()
    {
        // dd(url());
        $services = Service::all();

        if ($services->count() == 0) {
            return $this->formatResponse(
                'error',
                'Services not found',
            );
        }

        $services->transform(function ($service) {

            $service['icon'] = $service->icon ? config('app.url') . $service->icon : '';
            $service['service_category'] = count($service->serviceCategories) > 0 ? true : false;
            // $service['service_category_item'] = count($service->serviceCategoryItem) > 0 ? true : false;
            // $service->serviceCategoryItem->transform(function ($item) {

            //     $item['icon'] = $item->icon ? config('app.url') . $item->icon : '';
            //     return $item;
            // });
            return $service;
        });

        return $this->formatResponse(
            'success',
            'Services found successfully',
            $services,
            200
        );
    }

    public function serviceCategoriesList($id)
    {
        $serviceCategories = ServiceCategory::where('service_id', $id)->get();

        if ($serviceCategories->count() == 0) {
            return $this->formatResponse(
                'error',
                'service category not found',
            );
        }
        return $this->formatResponse(
            'success',
            'service category found successfully',
            $serviceCategories,
            200
        );
    }

    public function servicesCategoryItems(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
            'service_id' => 'sometimes',
            'category_id' => 'sometimes',
        ]);

        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }

        $item = [];

        if ($request->has('latitude') && $request->has('longitude')) {
            $serviceCategoryItems = ServiceCategoryItem::select(['id', 'lat', 'lng'])->get();
            foreach ($serviceCategoryItems as $serviceCategoryItem) {
                $distance = (int) get_meters_between_points($serviceCategoryItem->lat, $serviceCategoryItem->lng, $request->latitude, $request->longitude);
                if ($distance <= 100) {
                    array_push($item, $serviceCategoryItem->id);
                }
            }
        }

        if ($request->has('service_id')) {
            if ($request->service_id == "23") {
                $data = ServiceCategoryItem::whereIn('id', $item)->get();
            }else{
                if($request->has('category_id')){
                    $data = ServiceCategoryItem::where('service_id',$request->service_id)->where('service_category_id', $request->category_id)->whereIn('id', $item)->get();
                }else{
                    $data = ServiceCategoryItem::where('service_id', $request->service_id)->whereIn('id', $item)->get();
                }
            }
        }

        if (count($data) == 0) {
            return $this->formatResponse(
                'error',
                'no data found',
            );
        }

        $data->transform(function ($item) {

            $item['icon'] = $item->icon ? config('app.url') .'/public/'. $item->icon : '';
            // $service['service_category'] = count($service->serviceCategories) > 0 ? true : false;
            return $item;
        });
        return $this->formatResponse(
            'success',
            'service category item found successfully',
            $data,
            200
        );
    }
}
