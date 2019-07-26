{{-- @extends('layouts.app') --}}
@extends('layouts.tem')

@section('content')

<div id="carouselExampleIndicators1" class="carousel slide" data-ride="carousel" style="background-color: grey">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators1" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators1" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators1" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
          <div class="carousel-item active"> <img class="d-block mx-auto" style="width:100%; height:200px" src="storage/files/screen1.png" alt="First slide">
            <div class="carousel-caption">
              <h5>First slide Heading</h5>
              <p>First slide Caption</p>
            </div>
          </div>
          <div class="carousel-item"> <img class="d-block mx-auto" style="width:100%; height:200px" src="storage/files/screen2.png" alt="Second slide">
            <div class="carousel-caption">
              <h5>Second slide Heading</h5>
              <p>Second slide Caption</p>
            </div>
          </div>
          <div class="carousel-item"> <img class="d-block mx-auto" style="width:100%; height:200px" src="storage/files/screen3.png" alt="Third slide">
            <div class="carousel-caption">
              <h5>Third slide Heading</h5>
              <p>Third slide Caption</p>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators1" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#carouselExampleIndicators1" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
</div>

<div class="container-fluid">
        
    <div class="row justify-content-center">
        <div class="col-md-8">
            <br />
                    <form method="POST" action="{{ route('user.edit', $user) }}">
                        @csrf
                        {{ csrf_field() }}
    {{ method_field('patch') }}

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right" title="Click to enter your name. This will display on your profile.">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" placeholder="E.g. Mr. John Snow" autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--
                        <div class="form-group row">
                            <label for="lecturer" class="col-md-4 col-form-label text-md-right" title="Click this if you are a lecturer.">{{ __('Lecturer') }}</label>

                            <div class="col-md-6">
                                <input id="lecturer" type="radio" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" name="status" value="lecturer" required>
                                @if ($errors->has('status'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <label for="student" class="col-md-4 col-form-label text-md-right" title="Click this if you are a student.">{{ __('Student') }}</label>

                            <div class="col-md-6">
                                <input id="student" type="radio" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" name="status" value="student" required>
                                @if ($errors->has('status'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        --}}

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right" title="Click to enter your email.">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}">
                                {{--<a class="btn btn-primary" disabled>@stu.edu.gh</a>--}}
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right" title="Click to enter your password.">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password must be at least 8 characters long" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right" title="Click to confirm your password.">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm password must match Password." required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" title="Click to register.">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
        </div>
    </div>
</div>
@endsection
