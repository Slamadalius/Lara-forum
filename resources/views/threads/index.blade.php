@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Forum Threads</div>

                <div class="card-body">
                    @foreach($threads as $thread)
                        <article>
                            <!-- href is getting a path funtion from Thread Model, which returns /threads/id -->
                            <div class="d-flex">
                                <div class="p-2">
                                    <h4>
                                        <a href="{{$thread->path()}}">
                                            {{$thread->title}}
                                        </a>
                                    </h4>
                                </div>
                                 
                                <div class="ml-auto p-2">
                                    <a href="{{ $thread->path() }}">{{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}</a>
                                </div>
                            </div>
                        
                            <div class="body">{{$thread->body}}</div>
                        </article>

                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
