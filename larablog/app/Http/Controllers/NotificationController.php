<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function show() {
        return view('users.notifications');
    }

    public function sendWebhook(Request $request) {

        $this->validate($request, [
            'destination' => 'nullable|url',
            'noti-options' => 'required_with:destination'
        ]);

        //old url saved in other file :)

        $url = $request->destination;
        $userLikes = auth()->user()->receivedLikes->count();

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);

        $headers = array(
            'Content-Type: application/json',
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = array('posterName' => "testName", 'likeCount' => $userLikes, 'content' => auth()->user()->name . " has ". $userLikes . " likes!");
        $data = json_encode($data);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_exec($curl);
        curl_close($curl);
        return redirect("/");
    }
}
