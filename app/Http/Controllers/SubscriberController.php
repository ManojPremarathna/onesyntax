<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{

    /**
     * @param Request $request
     *
     * Save subscriber email and website
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'email'      => 'required|email',
            'website_id' => 'required',
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

        if(Subscriber::where('email', '=', $request->email)->where('website_id', '=', $request->website_id)->exists()) {
            return response()->json(
                [
                    'success' => false,
                    'errors'  => ['email' => ["You have already subscribe to this site"]]
                ],
                500
            );
        }

        $post = new Subscriber();
        $post->email      = $request->email;
        $post->website_id = $request->website_id;
        $post->save();

        return response()->json(
            [
                'success' => true,
                'data'    => 'Subscribe successful'
            ],
            200
        );
    }

    public function subscribe(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'email' => 'required|email',
        ]);

        if($validation->fails()){
            return response()->json(
                [
                    'success' => false,
                    'errors'  => $validation->errors()->first()
                ]
            );
        }

        if(Subscriber::where('email', '=', $request->email)->where('website_id', '=', $request->website_id)->exists()) {
            return response()->json(
                [
                    'success' => false,
                    'errors'  => "You have already subscribe to this site",
                ]
            );
        }

        $post = new Subscriber();
        $post->email      = $request->email;
        $post->website_id = $request->website_id;
        $post->save();

        return response()->json(
            [
                'success' => true,
                'data'    => 'Subscribe successful'
            ],
            200
        );
    }
}
