@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{$thread->creator->name}}</a> posted: {{$thread->title}}
                    </div>

                    <div class="card-body">{{$thread->body}}</div>
                </div>

                <br>

                <div class="card-header">Replies</div>
                <!-- We looping through replies which belongs to a certain thread -->
                @foreach ($replies as $reply)
                    @include ('threads.reply')
                    <br>
                @endforeach

                {{ $replies->links() }}

                @auth
                    <form method="POST" action="{{$thread->path() . '/replies'}}">
                        <!-- allways have to add csrf_field() in a form -->
                        @csrf
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Have something to say?" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Post</button>
                    </form>
                @endauth

                @guest
                    <p class="text-center">Please <a href="{{route('login')}}">sign in</a> to participate in this discussion</p>
                @endguest
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>This thread was published {{ $thread->created_at->diffForHumans() }} 
                        by <a href="#" class="">{{ $thread->creator->name }}</a>,
                        {{-- we can use replies_count attribute because of globalScope in boot method Thread model / using laravel function str_plural to add 's' if more then 1 reply --}}
                        and currently has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}.
                        </p>    
                    </div>
                </div>
            </div>
        </div>
    </div>  
@endsection
