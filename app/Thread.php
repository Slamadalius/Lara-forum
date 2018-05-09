<?php

namespace App;

use App\User;
use App\Reply;
use App\Channel;
use App\Activity;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    //trait to record activities with thread
    use RecordsActivity;

    protected $guarded = [];

    //You can also add global scope if you need to disable the query that fetches creator as well
    protected $with = ['creator', 'channel'];

    //boot method that adds replies_count to every thread.
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function($builder){
            $builder->withCount('replies');
        });

        //deletes all the replies assosiated with a thread when deleting it (activities as well)
        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });
    }

    public function path() 
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    //Creating replies elequant relationship (thread can have many replies)
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    //Creating user elequant relationship (thread belongs to a User)
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id'); //We have to specify foreign key 'user_id' because owner name is used
    }

    //Creating channel elequant relationship (thread belongs to a Channel)
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    //Add Reply
    public function addReply($reply)
    { 
        //creating a reply
        $this->replies()->create($reply);  
    }

    //Setting up a query scope that accepts query and filters from ThreadFilters model (passed from ThreadController)
    public function scopeFilter($query, $filters)
    { 
        //apply filters to a thread query we are running
        return $filters->apply($query);
    }
}
