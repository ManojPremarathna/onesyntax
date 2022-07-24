<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'title'       => 'required',
            'description' => 'required',
            'website_id'  => 'required',
        ]);

        if($validation->fails()){
            return response()->json(
                [
                    'success' => false,
                    'errors'  => $validation->errors()
                ],
                500
            );
        }

        if(!Website::where('id', '=', $request->website_id)->exists()) {
            return response()->json(
                [
                    'success' => false,
                    'errors'  => ['website_id' => ['Website id not exits please check']]
                ],
                500
            );
        }

        $post = new Post();
        $post->title       = $request->title;
        $post->description = $request->description;
        $post->website_id  = $request->website_id;
        $post->save();

        // send emails to subscribers
        $subscribers = Subscriber::where('website_id', '=', $request->website_id)->get();

        foreach ($subscribers as $subscriber) {
            dispatch(new SendEmailJob($subscriber, $post));
        }

        return response()->json(
            [
                'success' => true,
                'data'    => $post
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Post $post)
    {
        return response()->json(
            [
                'success' => true,
                'data'    => $post
            ],
            200
        );
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, Post $post)
    {
        $validation = Validator::make($request->all(),[
            'title'       => 'required',
            'description' => 'required',
            'website_id'  => 'required',
        ]);

        if($validation->fails()){
            return response()->json(
                [
                    'success' => false,
                    'errors'  => $validation->errors()
                ],
                500
            );
        }

        if(!Website::where('id', '=', $request->website_id)->exists()) {
            return response()->json(
                [
                    'success' => false,
                    'errors'  => ['website_id' => ['Website id not exits please check']]
                ],
                500
            );
        }

        $post->title       = $request->title;
        $post->description = $request->description;
        $post->website_id  = $request->website_id;
        $post->save();

        return response()->json(
            [
                'success' => true,
                'data'    => $post
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json(
            [
                'success' => true,
                'data'    => 'Post deleted'
            ],
            200
        );
    }
}
