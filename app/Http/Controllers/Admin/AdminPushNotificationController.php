<?php

namespace App\Http\Controllers\Admin;

use App\Models\PushNotification;
use App\Models\User;
use App\Models\UserDeviceToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;

class AdminPushNotificationController  implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function sendNotification(Request $request)
    {
        $users = User::where('status',1)->get()->pluck('id')->toArray();
        if(count($users) > 0){
            $send_notification = [];
            $send_notification['user_id'] = $users;
            $send_notification['title'] = $request->title;
            $send_notification['body'] = $request->body;
            $send_notification['url'] = $request->url;
            $send_notification['admin_id_from'] = auth()->user()->id;
            $send_notification['type_id'] = auth()->user()->id;
            $send_notification['type'] = Chat;
        
            send_notification($send_notification);
        }
       return back()->with('success', 'Successfully Send');
    }

    public function get_all_notifications(Request $request)
    {
        
    $notifications = PushNotification::where('to_user_id',1)->orderBy('id','DESC')->take(15);

        if($notifications->count() > 0){
            return response()->json([
                'code' => 200,
                'notifications' => $notifications->get()->map(function($row){
                return [
                    'id' => $row->id,
                    'title' => $row->title,
                    'body' => $row->body,
                    'admin_id_from' => $row->admin_id_from,
                    'to_user_id' => $row->user_id_to,
                    'from_user_id' => $row->user_id_from,
                    'un_read' => $row->un_read,
                    'body' => $row->body,
                    'url' => config('app.url').'/'. auth()->user()->type . $row->url,
                    'created_at' => $row->created_at->diffForHumans(),
                    
                    ];
                    }),
                'notitfication_count' => $notifications->count(),
                'all_unread_count' => $notifications->where('un_read',0)->count(),
            ]);
        }else{
            return response()->json([
                'code' => 404,
                'notitfication_count' => $notifications->count(),
                'all_unread_count' => $notifications->where('un_read',0)->count(),
                'notifications' => 'No notifications found.'
            ]);
        }
    }

    public function notification_redirect($notification_id){
        $notification = PushNotification::where('id',$notification_id)->first();
        $notification->un_read = 1;
        $notification->save();
        return redirect($notification->url);
    }

    public function dissmiss_all_notifications(){
        $notifications = PushNotification::where('to_user_id',1)->where('un_read',0)->update(array(
            'un_read' => 1
        ));

        $notifications = PushNotification::where('to_user_id',1)->orderBy('id','DESC')->take(10);

        if($notifications->count() > 0){
            return response()->json([
                'code' => 200,
                'notifications' => $notifications->get(),
                'notitfication_count' => $notifications->count(),
                'all_unread_count' => $notifications->where('un_read',0)->count(),
            ]);
        }else{
            return response()->json([
                'code' => 404,
                'notitfication_count' => $notifications->count(),
                'all_unread_count' => $notifications->where('un_read',0)->count(),
                'notifications' => 'No notifications found.'
            ]);
        }
    }

    function all_notifications(Request $request){

        if ($request->ajax()) {
            $data = PushNotification::select('*')->where('to_user_id',1)->orderBy('id','DESC');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('from_user_id', function ($row) {
                   $user = User::select('id','name')->where('id',$row->from_user_id)->first();
                   $from_user_id = $user ? $user['name'] : '-';
                    return $from_user_id;
                })
                ->addColumn('status', function ($row) {
                    $status = $row->un_read == 0 ? 'Un-Read' : 'Read';
                    return $status;
                })
                ->addColumn('created_at', function ($row) {
                    $created_at = Carbon::create($row->created_at)->format('F j Y - h:m a');
                    return $created_at;
                })
                ->addColumn('action', function ($row) {
                    // $btn = '<a href="' .$row->url . '" class="fa fa-eye btn btn-outline-success"></a>';
                    // return '<div class="d-flex btnWrap">'.$btn.'</div>';
                    $url = $row->url;
                    $btn = '<div class="d-flex btnWrap"><a href="'. config('app.url')."/".auth()->user()->type .$url .'" class="fa fa-eye btn btn-outline-success"></a>';
                    if(auth()->user()->parent_id == null){
                        $btn .= '<a href="'.route(auth()->user()->type.'.delete_notification',[$row->id]).'"  onclick="return confirm(`Are you sure you want to delete it?`)" class="fa fa-trash-alt btn btn-outline-danger"></a></div>';
                    }
                    return $btn;
                })

                ->rawColumns(['status','created_at','from_user_id','action'])
                ->make(true);
        }


        return view('Admin.Notification.all-notifications', get_defined_vars());
    }

    public function notificationSetting(){
        return view('Admin.Notification.notification-setting');
    }

    public function notificationSettingStore(Request $request){
        // dd($request->all());

        $user = User::find(Auth::id());

        if ($request->has('create_notify')) {
            $user->notify_created = 1;
        }
        if ($request->has('create_email')) {
            $user->notify_created = 2;
        }
        if ($request->has('create_notify') && $request->has('create_email')) {
            $user->notify_created = 3;
        }
        if ($request->has('reject_notify')) {
            $user->notify_rejected = 1;
        }
        if ($request->has('reject_email')) {
            $user->notify_rejected = 2;
        }
        if ($request->has('reject_notify') && $request->has('reject_email')) {
            $user->notify_rejected = 3;
        }
        if ($request->has('withdrawn_notify')) {
            $user->notify_withdrawn = 1;
        }
        if ($request->has('withdrawn_email')) {
            $user->notify_withdrawn = 2;
        }
        if ($request->has('withdrawn_notify') && $request->has('withdrawn_email')) {
            $user->notify_withdrawn = 3;
        }
        $user->save();
        
        return redirect()->route(auth()->user()->type.'.notification_setting')->with('success','Setting Saved Successfully');
    }
    
    public function deleteNotification($id)
    {
        // dd($id);
        $notify = PushNotification::find($id);
        $notify->delete();
        
        return redirect()->route(auth()->user()->type.'.all_notifications')->with('success','Notification Deleted Successfully');
    }
}
