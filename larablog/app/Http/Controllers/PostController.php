<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\Mime;
use Symfony\Component\Finder\Iterator\FilenameFilterIterator;
use Illuminate\Support\Facades\DB;


class PostController extends Controller
{
    public function __construct()
    {   
        $this->middleware(['auth'])->only(['store', 'destroy']);
    }

    public function index() {

        $posts = Post::latest()->with(['user', 'likes'])->paginate(3); //all posts
        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function show(Post $post) {
        return view('posts.show', [
            'post' => $post
        ]);
    }

    public function store(Request $request) {
        //dd("sorry, our file upload currently doesn't work :) this is a placeholder");
        $this->validate($request, [
            'body' => "required",
            'img' => "nullable|image|mimes:png,jpg,jpeg,svg,gif|max:2048"
        ]);

        $newPost = new Post;
        $newPost->body = $request->body;
        //$path = NULL;
        if($request->hasFile('img')) {
            $filenameWithExtension = $request->file('img')->getClientOriginalName();
            $fileName = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('img')->getClientOriginalExtension();
            $filenameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('img')->storeAs('public/imgs', $filenameToStore);
            $newPost->img = $path;
        }

        //$request->user()->posts()->create($request->only(['body']));
        $request->user()->posts()->save($newPost);

        //send webhook
        app('App\Http\Controllers\NotificationController')->sendWebhook($request->user(), 1);

        return back();
    }

    public function destroy(Post $post) {
        $this->authorize('delete', $post); //throws exception
        $post->delete();

        return back();
    }
}
