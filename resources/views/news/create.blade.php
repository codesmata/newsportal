@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <a class="btn btn-success" href="{{ URL::previous() }}">Back</a>
                        <span> Add News Article</span>
                    </div>
                    <div class="panel-body">
                        @if (Session::has("success"))
                            <span class="alert alert-success">
                            <strong>News added successfully..</strong>
                        </span>
                        @endif

                        @if (count($errors) > 0)
                            <span class="alert alert-danger">
                                    <strong>{{ $errors->first() }}</strong>
                                </span>
                        @endif


                        <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="/news">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="title" class="control-label col-sm-4 ">Title</label>
                                <div class="col-sm-8">
                                    <input name="title" class="form-control" value="{{ old('title')}}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="control-label col-sm-4 ">body</label>
                                <div class="col-sm-8">
                                    <textarea name="body" class="form-control" required>{{ old('body')}}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="image" class="control-label col-sm-4 ">Upload IMage</label>
                                <div class="col-sm-8">
                                    <input type="file" name="photo" class="form-control" placeholder="Upload Image">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-8 pull-right">
                                    <button type="submit" class="btn btn-success">GO!</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection