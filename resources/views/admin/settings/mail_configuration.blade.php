@extends('admin.dashboard')
@section('title','Mail configuration')
@section('content')

<div class="right_col">
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Configure <small> system mailing information</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <form id="demo-form2" method="post" class="form-horizontal form-label-left" novalidate="">@csrf

                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">E-mail Server<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" class="form-control" name="server" value="smtp" readonly="">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Configuring email <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                 <input type="text" class="form-control" name="username" value="{{$info->username}}">
                                 <span class="text-danger">{{ $errors->first('username')}}</span>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">eMail Password</label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" name="password" class="form-control" value="{{$info->password}}">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Referrence email (sent from email)</label>
                            <div class="col-md-6 col-sm-6 ">
                               <input type="text" class="form-control" name="send_email" value="{{$info->send_email}}">
                            </div>
                        </div>
                        <div class="item form-group">
                            <div class="col-md-3"></div>
                            <div class="col-md-6 col-sm-6 offset-3">
                                <button type="submit" class="btn text-center btn-success"><i class="fa fa-edit"></i> Update Configuration</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection