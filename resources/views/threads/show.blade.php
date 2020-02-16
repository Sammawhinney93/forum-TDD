@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
{{--                    <a href="#"> {{$thread->creator->name}}</a> posted::--}}
                    <div class="card-header">{{$thread->title}}</div>

                    <div class="card-body">
                        {{$thread->body}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>
        @if (Auth()->check())
            <div class="row justify-content-cent er">
                <div class="col-md-8">
                    <form method="POST" action="{{$thread->path() . '/replies'}}">
                        {{csrf_field()}}
                        <br>
                        <div class="form-group">
                            <textarea  name="body" id="body" class="form-control" placeholder="Have something to say?"
                                      rows="5"></textarea>
                        </div>

                        <button type="submit" class="btn btn-default">Post</button>
                    </form>
                </div>
            </div>
        @else
            <p class="text-center"> Please <a href="{{route('login')}}"> sign in </a> to participate in this discussion</p>
        @endif
    </div>
@endsection

