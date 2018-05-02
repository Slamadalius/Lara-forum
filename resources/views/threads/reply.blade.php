<div class="card">

    <div class="d-flex">
        <div class="p-2">
                <div class="">
                <!-- showing reply owner(relationship in Reply model) and created at -->
                    <a href="#">{{$reply->owner->name}}</a> said {{$reply->created_at->diffForHumans()}}
                </div>
        </div>
            
        <div class="ml-auto p-2">
            @auth
            <form method="POST" {{ $reply->isFavorited() ? 'action=/replies/'.$reply->id.'/unfavorite' : 'action=/replies/'.$reply->id.'/favorites' }} >
                @csrf
                <button type="submit" class="btn {{ $reply->isFavorited() ? 'btn-success' : 'btn-default' }}">
                    {{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}
                </button>
            </form>
            @endauth
        </div>
    </div>

    <div class="card-body">
        {{$reply->body}}
    </div>
</div>