@extends('layouts.app')

@section('content')
    <article>
        <!-- Breadcrumb -->
        <section class="theme-breadcrumb pad-50">
            <div class="theme-container container ">
                <div class="row">
                    <div class="col-sm-8 pull-left">
                        <div class="title-wrap">
                            <h2 class="section-title no-margin"> Merchant Sign In </h2>
                            <p class="fs-16 no-margin"> If you have an account with Fine Courier , please log in. </p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb-menubar list-inline">
                            <li><a href="{{route('home')}}" class="gray-clr">Home</a></li>
                            <li class="active">sign in</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.Breadcrumb -->

        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-6 col-md-offset-4">
                    <div class="login-wrap">
                        <div class="login-form" style="border-top: 0">
                            @if(session()->has('login_error'))
                                <div class="alert alert-danger alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ session()->get('login_error') }}
                                </div>
                            @endif
                            <form method="POST" class="login" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="email" value="{{ old('email') }}" class="form-control" placeholder="Enter your email address" name="email" max="100" required>
                                    @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" min="8" max="20"
                                           placeholder="Enter password" name="password" value="">
                                    @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="checkbox text-left">
                                    <label><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}</label>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn-1"> Sign in now</button>
                                </div>
                            </form>
                            <a href="#" class="gray-clr"> Forgot Password? </a>
                        </div>
                    </div>
                    <div class="create-accnt" style="margin-top: 0;background-color: white;">
                        <span> Don’t have an account? </span>
                        <h2 class="title-2"><a href="{{route('register')}}" class="green-clr under-line">Create a free account</a></h2>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endsection
