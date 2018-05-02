<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Favorites;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Reply $reply)
    {
        $attributes = ['user_id' => auth()->id()];

        //if a record doesn't exist
        if(!$reply->favorites()->where($attributes)->exists()) {
            //because we are using morph relationiship we can specify only the user_id as favorited is going to be set up automaticaly
            $reply->favorites()->create($attributes);
        }

        return back();
        


        // Favorites::create([
        //     'user_id' => auth()->id(),
        //     'favorited_id' => $reply->id,
        //     'favorited_type' => get_class($reply)
        // ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $attributes = ['user_id' => auth()->id()];

        $reply->favorites()->delete($attributes);

        return back();
    }
}
