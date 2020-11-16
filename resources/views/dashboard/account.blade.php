@extends('dashboard.layout.app')
@section('pageTitle','Account Setting')
@section('content')
    <style>
        .card-title{
            font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
        }
    </style>
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fa fa-cog text-success">
                    </i>
                </div>
                <div>{{Auth::guard('user')->user()->first_name}} {{Auth::guard('user')->user()->last_name}} Account Setting
                    <div class="page-title-subheading">You can change email and password here
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{$error}}
                </div>
            @endforeach
        @endif
        @if(session()->has('message'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="row">
                <div class="col-md-6">
                    <div class="main-card mb-3 card">
                        <div class="card-body"><h5 class="card-title">Change your email address</h5>
                            <form class="" autocomplete="off" method="post" action="{{route('ChangeMail')}}">
                                @csrf
                                <input type="hidden" name="id" value="{{Auth::guard('user')->user()->id}}">
                                <div class="position-relative form-group"><input
                                        id="exampleEmail" value="{{Auth::guard('user')->user()->email}}" type="email"
                                        class="form-control" readonly></div>
                                <div class="position-relative form-group"><input
                                        name="email" autocomplete="off" id="exampleEmail" placeholder="Enter your new email address" type="email"
                                        class="form-control" required></div>
                                <div class="position-relative form-group"><input
                                        name="password" id="examplePassword" placeholder="Enter your password"
                                        type="password" class="form-control" required></div>
                                <button class="mt-1 btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="main-card mb-3 card">
                        <div class="card-body"><h5 class="card-title">Change your password</h5>
                            <form method="post" action="{{route('ChangePassword')}}">
                                @csrf
                                <input type="hidden" name="id" value="{{Auth::guard('user')->user()->id}}">
                                <div class="position-relative form-group"><input
                                        name="old_password" id="examplePassword" placeholder="Enter your old password"
                                        type="password" class="form-control"></div>
                                <div class="position-relative form-group"><input
                                        name="password" id="examplePassword" placeholder="Enter your new password"
                                        type="password" class="form-control"></div>
                                <div class="position-relative form-group"><input
                                        name="password_confirmation" id="examplePassword" placeholder="Confirm your password"
                                        type="password" class="form-control"></div>
                                <button class="mt-1 btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
