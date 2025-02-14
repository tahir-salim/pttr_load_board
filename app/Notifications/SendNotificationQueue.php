<?php

namespace App\Notifications;

use App\Models\PushNotification;
use App\Models\User;
use App\Models\UserDeviceToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\FirebaseChannel;
use Illuminate\Notifications\Notification;
use Google\Client;
    
class SendNotificationQueue extends Notification implements ShouldQueue
{
    use Queueable;

    public $title = '';
    public $body = '';
    public $action = '';
    public $icon = 'http://localhost:8000/assets/images/logo-light.png';
    public $data = [];



    public function __construct($title, $body, $action ,$data = [])
    {

        $this->title = $title;
        $this->body = $body;
        $this->action = $action;
        $this->data = $data;
    }

    public function via($notifiable)
    {

        return [FirebaseChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toFirebase($notifiable)
    {




        $userDevice = UserDeviceToken::where('device_token',$notifiable)->orderBY('id', 'asc')->get();

        // if($userDevice){
        //     if(isset($this->data['admin_id_from'])){
        //         $usr_id = '';
        //         foreach( $userDevice as $k => $item){
        //             $item = $item->user;
        //             if($item->id != $usr_id){
        //                 PushNotification::create([
        //                     'title' => $this->data['title'],
        //                     'body' => $this->data['body'] ,
        //                     'admin_id_from' => isset($this->data['admin_id_from']) ? $this->data['admin_id_from'] : null,
        //                     'to_user_id' => $item->id ,
        //                     'url' => $this->data['url'] ,
        //                     'un_read' => 0,
        //                 ]);
        //             }
        //             $usr_id = $item->id;
        //         }
        //     }else{
        //         $usr_id = '';

        //         foreach($userDevice as $k => $item){
        //             $item = $item->user;


        //             if($item->id != $usr_id){
        //                 PushNotification::create([
        //                     'title' => $this->data['title'],
        //                     'body' => $this->data['body'] ,
        //                     'from_user_id' => isset($this->data['from_user_id']) ? $this->data['from_user_id'] : null  ,
        //                     'to_user_id' => $item->id ,
        //                     'url' => $this->data['url'] ,
        //                     'un_read' => 0,
        //                 ]);
        //             }
        //             $usr_id = $item->id;
        //         }
        //     }
        // }
        
        
    
        $serviceAccountPath = base_path('/public/assets/pttr-12c10-8b5376f3063c.json');

        // Step 1: Create the Google Client
        $client = new Client();
        $client->setAuthConfig($serviceAccountPath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        // Get the OAuth 2.0 access token
        $accessToken = $client->fetchAccessTokenWithAssertion()['access_token'];
        // Step 2: Send Push Notification using the access token
        $data = [
            "message" => [
                "token" => $notifiable, // The device registration token
                "notification" => [
                    "title" => $this->title,
                    "body" => $this->body,
                    // "click_action" => $this->action,
                    // "icon" => $this->icon,
                ],
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/pttr-12c10/messages:send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        // echo $response;
        curl_close($ch);

        // $SERVER_API_KEY = 'AAAAsQWV3Io:APA91bFWH_8MdDWSZ3XIxjXA4upkzFYM_ZTur49dLQL88MyvtphbtU8RQBt-WLUYJPcW1uD4_79IYd39SbFa0SxcHqBpcY3kTX7OPiIDwsa2EhnerPF08OSoYThQ3VdsgN0MVW8Mugfw';
        // $data = [
        //     "registration_ids" => [$notifiable],
        //     "notification" => [
        //         "title" => $this->title,
        //         "body" => $this->body,
        //         "action" => $this->action,
        //         "icon" => $this->icon,
        //     ]
        // ];
        // $dataString = json_encode($data);;
        // $headers = [
        //     'Authorization: key=' . $SERVER_API_KEY,
        //     'Content-Type: application/json',
        // ];

        // $ch = curl_init();

        // curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/pttr-12c10/messages:send');
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        // $response = curl_exec($ch);
        // echo  $response;

        // echo $response;

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
