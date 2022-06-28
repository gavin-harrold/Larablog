<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function show() {
        return view('users.notifications');
    }

    /*
        SAVE INFO IN DB
        @param $request current request data
        @desc save user's information from form on /notifications into the database in order to retrieve on event calls
    */
    public function store(Request $request) {

        $this->validate($request, [
            'destination' => 'nullable|url',
            'noti_options' => 'required_with:destination'
        ]);

        //old url saved in other file :)

        $url = $request->destination;

                //store int instead of string for simplicity when retrieving from DB
                switch($request->noti_options) {
                    case('post-create'):
                        $selected_option = 1;
                        break;
                    case('post-like'):
                        $selected_option = 2;
                        break;
                    case('all-option'):
                        $selected_option = 3;
                        break;
                    default:
                        $selected_option = 0;
                }
        
                DB::table('users')
                    ->where('email', auth()->user()->email)
                    ->update([
                        'destination_url' => $url,
                        'notification_option' =>  $selected_option
                    ]);
        return redirect("/");
    }

    /*
        SEND WEBHOOK
        @param $user current user
        @param $expectedValue expected value of function call, 1 or 2 representing post created or post liked 
        @desc send webhook to user based on their settings
    */
    public function sendWebhook($user, $expectedValue) {
        //user doesn't have a saved destination_url, meaning cannot have a notification option
        if(DB::table('users')->where('destination_url', null)->exists()) {
            return;
        }
                
        //pull URL and notification option from database using unique email (can be changed to ID)
        $url = DB::table('users')
            ->where('email', $user->email)
            ->select('destination_url')
            ->get();

        $notification_option = DB::table('users')
            ->where('email', $user->email)
            ->get('notification_option');
              
        //get actual value from collection returned by get()
        $notification_option = $notification_option[0]->notification_option;    

        //define empty variable for body content specifically for Discord, could pertain to others?
        $contentBody = null;

        //if user has all notifications on, change to react to whatever event is currently being called
        if($notification_option === 3) {
            $notification_option = $expectedValue;
        }

        //check for current call and change message body accordingly
        if($notification_option === $expectedValue) {
            switch($notification_option) {
                case(1):
                    $contentBody = $user->name . " has just created a post!";
                    break;
                case(2):
                    $contentBody = $user->name . " has received a like! They now have " . $user->receivedLikes->count() . " likes!";
                    break;
                default:
                    return;
            }
        }

        //curl stuff to send webhook
        $url = $url[0]->destination_url;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);

        $headers = array(
            'Content-Type: application/json',
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = array('posterName' => "testName", 'content' => $contentBody);
        $data = json_encode($data);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_exec($curl);
        curl_close($curl);
    }
    
}
