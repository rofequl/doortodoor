@extends('layouts.app')

@section('content')
    <article>
        <!-- Breadcrumb -->
        <section class="theme-breadcrumb pad-50">
            <div class="theme-container container ">
                <div class="row">
                    <div class="col-sm-8 pull-left">
                        <div class="title-wrap">
                            <h2 class="section-title no-margin"> Merchant Register </h2>
                            <p class="fs-16 no-margin"> Create your account </p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb-menubar list-inline">
                            <li><a href="{{route('home')}}" class="gray-clr">Home</a></li>
                            <li class="active">register</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.Breadcrumb -->

        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-10 col-sm-offset-1  col-md-offset-2">
                    <div class="regi_form_wrapper">
                        <div class="quote_form">
                            <form action="{{route('register.store')}}" method="post" id="Signup-Form"
                                  autocomplete="off">
                                @csrf
                                <div class="row" style="margin-bottom:15px">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="title-2"> First Name: </label>
                                            <input type="text" value="{{ old('first_name') }}" class="form-control"
                                                   placeholder="First Name" name="first_name" max="50" required>
                                            @error('first_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="title-2"> Last Name: </label>
                                        <input type="text" value="{{ old('last_name') }}" class="form-control"
                                               placeholder="Last Name" name="last_name" max="50" required>
                                        @error('last_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom:15px">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="title-2"> Email: </label>
                                            <input type="email" value="{{ old('email') }}" class="form-control"
                                                   placeholder="Enter your email address" name="email" max="100"
                                                   required>
                                            @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="title-2"> Phone: </label>
                                        <input type="number" value="{{ old('phone') }}" class="form-control"
                                               placeholder="Enter your phone number" name="phone" required>
                                        @error('phone')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom:15px">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="title-2"> Password: </label>
                                            <input type="password" class="form-control" min="8" max="20"
                                                   placeholder="Enter password" name="password" required>
                                            @error('password')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="title-2"> Confirm Password: </label>
                                        <input type="password" class="form-control" min="8" max="20" required
                                               placeholder="Confirm your password" name="password_confirmation">
                                        @error('password_confirmation')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom:35px">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <button class="btn-1"> Register</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </article>
@endsection
