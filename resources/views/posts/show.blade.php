{{-- @extends('layouts.app') --}}
@extends('layouts.tem')

@section('content')

<div class="card">
    <br />
    <h5 class="text-left"><a href="" class="black"> {!!$post->user->name!!} </a></h5>
    <strong class="text-left"> &nbsp Updated {{$post->updated_at->diffForHumans()}} &nbsp </strong>
    <h1 class="text-center"> {!!$post->title!!} </h1>
    
    <h3> &nbsp {!!$post->body!!} </h3>
    <br />
    @if($post->image)
        <img style="width:100%" src="storage/files/{{$post->image}}" />
        <a class="btn btn-default" title="Click to download image" href="storage/files/images/{{$post->image}}" download> Download <br /> {{$post->image}} </a>
    @else

        <a class="btn btn-default" title="Click to download file" href="storage/files/documents/{{$post->file}}" download> Download <br /> {{$post->file}} </a>

        <?php

            //echo readfile("storage/files/documents/$post->file");

            /*
            $myFile = fopen("storage/files/documents/$post->file", "r") or die("Unable to open file!");
            echo fread($myFile, filesize("storage/files/documents/$post->file"));
            //fclose($myFile);
            */
        ?>
    @endif
    <br />
    <small class="text-right">Updated on {{$post->updated_at->toDayDateTimeString()}} &nbsp </small>
    <br />
    <small class="text-right">Created on {{$post->created_at->toDayDateTimeString()}} &nbsp </small>
    <br />
    <br />
    <div class="row">
        @if(!Auth::guest())
            @if(Auth::user()->id == $post->user_id)
                <div class="col-6 text-left">
                    <a class="btn btn-primary" title="Click to edit post" href="../show/{{$post->id}}/edit"> Edit </a>
                </div>
                <div class="col-6 text-right">
                    {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'text-right'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-danger', 'title' => 'Click to delete post'])}}
                    {!!Form::close()!!}
                </div>
            @endif
        @endif
    </div>
    <div class="text-left">
        <h4> <a class="btn btn-default" title="Click to go back" href="../"> <<-Go back</a> </h4>
    </div>
</div>
@endsection()