<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    //Applying auth middleware to store method
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($channelId, Thread $thread)
    {
        $this->validate(request(), [
            'body'=>'required'
        ]);

        //Getting addReply method from Thread model
        $thread->addReply([
            //passing body from a request
            'body' => request('body'),
            //authenticated user id
            'user_id' => auth()->id() // or Auth::id()
        ]);

        //redirecting back to where the form was submited 
        return back();
    }
}
