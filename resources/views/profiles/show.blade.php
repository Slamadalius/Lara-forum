@extends('layouts.app')

@section('content')
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">
                {{$profileUser->name}}  
            </h1>
            <p class="lead">With us since {{$profileUser->created_at->diffForHumans()}}</p>

            <hr>
        </div>
    </div>
    <div class="container">
        <div class="row ">
            @foreach($activities as $date=>$activity)
            <h3 class="">{{$date}}</h3>
                @foreach($activity as $record)
                    @include("profiles.activities.{$record->type}", ['activity'=>$record])
                @endforeach 
            @endforeach

            {{-- {{$threads->links()}} --}}
        </div>
    </div>
@endsection
