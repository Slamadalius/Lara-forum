@extends('layouts.app')

@section('content')
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">
                {{$profileUser->name}}  
            </h1>
            <p class="lead">With us since {{$profileUser->created_at->diffForHumans()}}</p>
        </div>
    </div>
    <div class="container">
        <div class="row ">
            @foreach($profileUser->threads as $thread)
            <div class="col-md-12">
                <div class="card">
                        <div class="card-header">
                            <a href="#">{{$thread->creator->name}}</a> posted: {{$thread->title}}
                        </div>
    
                        <div class="card-body">{{$thread->body}}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
