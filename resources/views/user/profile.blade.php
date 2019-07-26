@extends('layouts.app')
{{-- @extends('layouts.tem') --}}

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                
                <div class="jumbotron">
                    <h3>
                        Name: {!!$user->name!!}
                        <br />
                        Email: {!!$user->email!!}
                        <br />
                        <a href="{{route('user.follow', $user->id)}}" class="btn btn-primary">Follow</a>
                        <a href="{{route('user.unfollow', $user->id)}}" class="btn btn-danger">Unfollow</a>
                        <br />
                        {{--<a href="{{Auth::user()->id}}/show" class="btn btn-default"> View profile </a>--}}
                        <a href="{{$user->id}}/show" class="btn btn-default"> View profile </a>
                    </h3>
                </div>
                
                @if(count($posts)>0)
                    @foreach ($posts as $post)
                        @if(!Auth::guest())
                            {{-- @if(Auth::user()->id == $post->user_id) --}}
                                <div class="card-body">
                                    <br />
                                    <h5 class="text-left"><a href="" class="black"> {!!$post->user->name!!} </a></h5>
                                    <strong class="text-left"> &nbsp Updated {{$post->updated_at->diffForHumans()}} &nbsp </strong>
                                    <h5 class="text-center"><a href="/show/{{$post->id}}" class="black"> {!!$post->title!!} </a></h5>
                                    <h6> <span style="display:block; text-overflow: ellipsis; width:3000px; overflow:hidden; white-space:nowrap; ">&nbsp  {!!$post->body!!} </span> <a href="/show/{{$post->id}}">&nbsp See full post... </a> </h6>
                                    {{--<img style="width:100%" src="storage/files/images{{$post->image}}" />--}}
                                    @if($post->document)
                                        <a class="btn btn-default" title="Click to download image" href="storage/files/documents/{{$post->document}}" download> Download {{$post->document}} </a>
                                    @endif
                                    @if($post->image)
                                        <img style="width:100%" src="storage/files/images/{{$post->image}}" />
                                        <a class="btn btn-default" title="Click to download image" href="storage/files/images/{{$post->image}}" download> Download {{$post->image}} </a>
                                    @endif
                                    <small class="text-right" font-size="10px">Updated on {{$post->updated_at->toDayDateTimeString()}}  &nbsp </small>
                                    <br />
                                    <small class="text-right">Created on {{$post->created_at->toDayDateTimeString()}} &nbsp </small>
                                    <br /> 
                                    <hr>  
                                </div>
                            {{-- @else --}}
                                {{--
                                <div class="card-body">
                                    <h6 class="text-center">There are no posts available for you.</h6>
                                </div>
                                --}}
                            {{-- @endif --}}
                        @endif
                    @endforeach
                    {{$posts->links()}}
                @else
                    <div class="card">
                        <h6 class="text-center">There are no posts available for you.</h6>
                    </div>
                @endif
        </div>
    </div>
</div>
@endsection