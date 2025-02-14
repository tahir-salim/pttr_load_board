<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FeedbackController extends Controller
{
    public function feedbacksList(Request $request)
    {
        if ($request->ajax()) {

            $data = Feedback::select("*")->orderBy('created_at', 'DESC');
            // dd($request->all());
            return DataTables::of($data)->addIndexColumn()->addColumn('created_at', function ($row) {
                 $r = $row->created_at != null ? $row->created_at->diffForHumans() : "-";
                return $r;
            })->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('id', 'LIKE', "%$search%")
                            ->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('email', 'LIKE', "%$search%")
                            ->orWhere('message', 'LIKE', "%$search%");
                    });
                }
            }) 
                ->addColumn('user_type', function ($row) {
                    return $row->user ? $row->user->type : '';
                })->rawColumns(['user_type'])
                
                 ->addColumn('action', function ($row) {
                     if(auth()->user()->parent_id == null){
                        $btn = '<a class="fa fa-trash-alt btn btn-outline-danger" href="' . route('super-admin.feedbacks.destroy', [$row->id]) . '" onclick="return confirm(`Are you sure you want to delete it?`)"  tile=""></a>';
                   
                        return $btn;
                    }
                })->rawColumns(['action'])
                ->make(true);
        }

        return view('Admin.feedbacks-list', get_defined_vars());
    }
    
    public function destroy($id){
        // dd($id);
        $feedback = Feedback::findorfail($id);
        $feedback->delete();
        return redirect()->route('super-admin.feedbacks_list')->with('success', 'Feedback removed Successfully!');
    }
}
