@extends('layouts.app')
{{-- @extends('layouts.tem') --}}

@section('content')
    

    @include('posts.create')
    <br />

    <hr />

    @if(count($posts)>0)
        @foreach ($posts as $post)
            <div class="card" style="margin: 10px 10px 10px 20px;">
                <br />
            <h5 class="text-left"><a href="user/{{$post->user->id}}" class="black"> &nbsp {!!$post->user->name!!} </a></h5>
                <br />
                
                <br />
                <strong class="text-left"> &nbsp Updated {{$post->updated_at->diffForHumans()}} &nbsp </strong>
                <br />
                <h5 class="text-center"><a href="/show/{{$post->id}}" class="black"> {!!$post->title!!} </a></h5>
                <br />
                <h6> <span style="display:block; text-overflow: ellipsis; width:3000px; overflow:hidden; white-space:nowrap; ">&nbsp  {!!$post->body!!} </span> <a href="show/{{$post->id}}">&nbsp See full post... </a> </h6>
                <br />
                {{--<img style="width:100%" src="storage/files/images{{$post->image}}" />--}}
                @if($post->file)
                    <a class="btn btn-default" title="Click to download file" href="storage/files/documents/{{$post->file}}" download> Download <br /> {{$post->file}} </a>
                @endif
                @if($post->image)
                    <img style="width:100%; height:500px" src="storage/files/images/{{$post->image}}" />
                    <a class="btn btn-default" title="Click to download image" href="storage/files/images/{{$post->image}}" download> Download <br /> {{$post->image}} </a>
                @endif
                <small class="text-right" font-size="10px">Updated on {{$post->updated_at->toDayDateTimeString()}}  &nbsp </small>
                <br />
                <small class="text-right">Created on {{$post->created_at->toDayDateTimeString()}} &nbsp </small>
                <br />
            </div>
            <hr>
        @endforeach
        {{--{{$posts->links()}}--}}
    @else
        <div class="card">
            <h6 class="text-center">There are no posts available for you.</h6>
        </div>
    @endif

@endsection