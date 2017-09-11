@extends('layouts.app')

@section('content')

    <style>

        #post-frame p{
            margin-top: 2em;
            font-weight: bolder;
        }

        #description {
            text-align: justify;
        }

        @media (max-width: 640px) {
            .col-md-10.col-sm-10.col-xs-10.col-md-offset-1.col-sm-offset-1 {
                padding: 0;
                margin-left: 8%;
            }
        }
    </style>

    <div class="container">

        <div class="row">
            <div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1">
                <div id="post-frame">
                    <img src="{{$news->photo}}">
                    <p><small><span>Uploaded by: {{str_limit("{$news->user->name} ", $limit = 20, $end = '...')}}</span>, {{$news->created_at->diffForHumans()}}</small></p>
                </div>
                <div id="description">
                    <h4>{{$news->title}}</h4>
                    <p>{{$news->body}}</p>
                </div>
            </div>
        </div>

    </div>
@endsection