<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Reviews;
class FeedbackController extends Controller
{
    public function feedback(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'message' => 'required',

        ]);

        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }
        $user = Auth::user();
        $feedback = new Feedback();
        $feedback->name = $user->name;
        $feedback->email = $user->email;
        $feedback->message = $request->message;
        $feedback->user_id = Auth::id();
        $feedback->save();

        return $this->formatResponse(
            'success',
            'feedback submitted successfully',
            $feedback,
            200
        );
    }
    
    public function create_rating(Request $request, $company_id){
        $validate = Validator::make($request->all(), [
            'rating_stars' => 'required',
        ]);
        
        $rating = new Reviews;
        $rating->company_id = $company_id;
        $rating->rating = $request->rating_stars;
        $rating->save();
        
        return $this->formatResponse(
            'success',
            'rating created successfully',
            $rating,
            200
        );
    }
}
