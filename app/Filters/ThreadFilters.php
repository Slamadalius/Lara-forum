<?php

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters
{
    //filter method (named as a filter itself)
    public function by($username)
    {
        //Apply filters
        $user = User::where('name', $username)->firstOrFail();

        //Returning builder with applied filter
        return $this->builder->where('user_id', $user->id);
    }

    //filter method (named as a filter itself)
    public function popular()
    {
        //Returning builder with applied filter to sort threads by replies_count
        return $this->builder->reorder('replies_count', 'desc');
    }
}