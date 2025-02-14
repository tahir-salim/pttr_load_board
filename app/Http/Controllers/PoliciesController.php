<?php



namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


class PoliciesController extends Controller
{

    public function terms_and_conditions()
    {
        return view('Global.term-and-conditions');
    }

    public function privacy_policy()
    {
        return view('Global.privacy-policy');
    }

    public function product_delivery_schedule()
    {
        return view('Global.product-delivery-schedule');
    }
    public function acceptable_use_policy()
    {
        return view('Global.acceptable-use-policy');
    }

}
