@extends('dashboard.layout.app')
@section('pageTitle',Auth::guard('user')->user()->first_name.' Profile')
@section('content')
    <div class="app-page-title main-card card" style="border-radius: 0;background-color: #fff">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon" style="width: 87px;height: 87px;padding: 0px">
                    <img src="{{Auth::guard('user')->user()->image==null? asset('images/user.png'):asset('storage/user/'.Auth::guard('user')->user()->image)}}" id="previewLogo" width="100%" height="100%" class="border p-1">
                </div>
                <div>{{Auth::guard('user')->user()->first_name.' '.Auth::guard('user')->user()->last_name}}
                    <div class="page-title-subheading">{{Auth::guard('user')->user()->email}}
                    </div>
                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <button type="button" onclick="location.href='{{route('ProfileEdit')}}';" class="btn-shadow btn btn-info">
                        <span class="btn-icon-wrapper pr-2 opacity-7"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
                        Edit Profile
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <table class="mb-0 table table-hover">
                        <tbody>
                        <tr>
                            <td style="width: 60%">Name:</td>
                            <td>{{Auth::guard('user')->user()->first_name.' '.Auth::guard('user')->user()->last_name}}</td>
                        </tr>
                        <tr>
                            <td>Shop Name:</td>
                            <td>{{Auth::guard('user')->user()->shop_name}}</td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td>{{Auth::guard('user')->user()->email}}</td>
                        </tr>
                        <tr>
                            <td>phone:</td>
                            <td>{{Auth::guard('user')->user()->phone}}</td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td>{{Auth::guard('user')->user()->address}}</td>
                        </tr>
                        <tr>
                            <td>Page / Website Link:</td>
                            <td>{{Auth::guard('user')->user()->website_link}}</td>
                        </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


@endsection
