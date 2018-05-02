<?php

namespace App;

use App\Thread;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    // By default Laravels model binding is trying to fetch an item according to it's id
    // so we have to override to use slug instead
    public function getRouteKeyName()
    {
        return 'slug';
    }

    //Creating threads elequant relationship (Channel has many Threads)
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
