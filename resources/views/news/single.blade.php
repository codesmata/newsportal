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

        <div id="printPdf" class="row">
            <div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1 well">
                <div id="post-frame">
                    {{--<img src="{{$news->photo}}">--}}
                    <p><small><span>Uploaded by: {{str_limit("{$news->user->name} ", $limit = 20, $end = '...')}}</span>, {{$news->created_at->diffForHumans()}}</small></p>
                </div>
                <div id="description">
                    <h2>{{$news->title}}</h2>
                    <p>{{$news->body}}</p>
                </div>
                <a class="btn btn-success btn-sm center" href="#" id="export_pdf">Export as PDF</a>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#export_pdf').on('click', function(event) {
                event.preventDefault();
                var element = document.getElementById('printPdf');
                html2pdf(element);
            })
        });
    </script>
@endsection