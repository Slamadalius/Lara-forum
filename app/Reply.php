<?php

namespace App;

use App\User;
use App\Favorites;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    //eager loading owner and favorites to reduce number of queries
    protected $with = ['owner', 'favorites'];

    //Creating owner elequant relationship (reply belongs to a user)
    public function owner() 
    {
        return $this->belongsTo(User::class, 'user_id'); //We have to specify foreign key 'user_id' because owner name is used
    }

    //Creating favorites elequant relationship (reply has many favorites)
    public function favorites() 
    {
        return $this->morphMany(Favorites::class, 'favorited'); 
    }

    //
    public function isFavorited() 
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
