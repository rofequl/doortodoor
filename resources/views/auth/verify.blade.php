@extends('layouts.app')

@section('content')

<article>
        <!-- Breadcrumb -->
        <section class="theme-breadcrumb pad-50">
            <div class="theme-container container ">
                <div class="row">
                    <div class="col-sm-8 pull-left">
                        <div class="title-wrap">
                            <h2 class="section-title no-margin"> Verify your Account </h2>
                            <p class="fs-16 no-margin"> Please check your email and get your login verification code </p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb-menubar list-inline">
                            <li><a href="{{route('home')}}" class="gray-clr">Home</a></li>
                            <li class="active">Verify account</li>
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
                            @if(session()->has('verification_error'))
                                <div class="alert alert-danger alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ session()->get('verification_error') }}
                                </div>
                            @endif

                            @if(session()->has('verification_email'))
                            <form method="POST" class="login">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control"placeholder="Enter verification code" name="verification_code" max="100" required>
                                </div>
                         
                                <div class="form-group">
                                    <button type="submit" class="btn-1"> Verify now</button>
                                </div>
                            </form>
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" style="float:right;background:white;border:1px solid;color:black;">{{ __('Resend Code') }}</button>.
                            </form>
                            @endif
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
