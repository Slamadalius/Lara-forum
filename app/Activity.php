<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    //subject associated with this activity
    public function subject()
    {
        //morphTo figures out what the apropriate relationship is
        return $this->morphTo();
    }

    //static function used in ProfilesController
    public static function feed($user, $take=50)
    {
        return $user->activities()
                ->latest()
                //getting latest user activities with subject
                ->with('subject')
                ->take($take)
                ->get()
                ->groupBy(function ($activity) {
                    //grouping by date Y-m-d
                    return $activity->created_at->format('Y-m-d');
                });
    }
}
