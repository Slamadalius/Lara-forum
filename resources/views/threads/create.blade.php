@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a New Thread</div>

                <div class="card-body">
                    <form method="POST" action="/threads">
                        @csrf
                        <div class="form-group">
                            <label for="channel_id">Select A Channel:</label>
                            <select id="channel_id" class="form-control{{ $errors->has('channel_id') ? ' is-invalid' : '' }}" name="channel_id">
                                <option value="">Choose one...</option>
                                {{-- channels variable passed in AppServiceProvider --}}
                                @foreach($channels as $channel)
                                    <!-- if old channel_id is equal to submitted channel id then add selected attribute -->
                                    <option value="{{$channel->id}}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>{{$channel->name}}</option>
                                @endforeach
                            </select>

                            <!-- If there is an error which has channel_id in it then error is shown near the corresponding field. -->
                            @if ($errors->has('channel_id'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('channel_id') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" autofocus>

                            @if ($errors->has('title'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="body">Body:</label>
                            <textarea rows="8" class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" name="body" id="body" placeholder="Write Your Thoughts" value="{{old('body')}}"></textarea>

                            @if ($errors->has('body'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('body') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Publish</button>
                        </div>
                        

                        <!-- @if(count($errors))
                        {{count($errors)}}
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        @endif -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
