<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Mail\PostLiked;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\WebhookServer\WebhookCall;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\DB;

class PostLikeController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['auth']);
    }

    public function store(Post $post, Request $request) {
        if($post->likedBy($request->user())) {
            return response(null, 409); //conflict
        }

        $post->likes()->create([
            'user_id' => $request->user()->id,
        ]);

        if(!$post->likes()->onlyTrashed()->where('user_id', $request->user()->id)->count()) { 
            //only email if no previous record of like (soft delete)
            Mail::to($post->user)->send(new PostLiked(auth()->user(), $post));
            
            //check if the receiver of like is the currently authenticated user for webhooks
            if($post->user == auth()->user()) {
                app('App\Http\Controllers\NotificationController')->sendWebhook($request->user(), 2);
            }
        }

        return back();
    }

    public function destroy(Post $post, Request $request) {
        $request->user()->likes()->where('post_id', $post->id)->delete();

        return back();
    }
}
