@extends('layouts.app')
@section('title','Contact us')
@section('content')
    <article>
        <!-- Breadcrumb -->
        <section class="theme-breadcrumb pad-50">
            <div class="theme-container container ">
                <div class="row">
                    <div class="col-sm-8 pull-left">
                        <div class="title-wrap">
                            <h2 class="section-title no-margin"> contact us </h2>
                            <p class="fs-16 no-margin"> Get in touch with us easily </p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb-menubar list-inline">
                            <li><a href="#" class="gray-clr">Home</a></li>
                            <li class="active">contact</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.Breadcrumb -->

        <!-- Contact Us -->
        <section class="contact-page pad-30">
            <div class="theme-container container">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-md-offset-1">
                        <ul class="contact-detail title-2 pt-50">
                           
                            <li class="wow fadeInUp" data-wow-offset="50" data-wow-delay=".40s"> <span>  Cell Numbers:</span> <p class="gray-clr"> {{basic_information()->phone_number_one}}<br>{{basic_information()->phone_number_two}}  </p> </li>

                            <li class="wow fadeInUp" data-wow-offset="50" data-wow-delay=".50s"> <span>Email address:</span> <p class="gray-clr"> {{basic_information()->email}} </p> </li>

                            <li class="wow fadeInUp" data-wow-offset="50" data-wow-delay=".60s"> <span>Meeting time:</span> <p class="gray-clr"> {{basic_information()->meet_time}}</p> </li>
                            
                        </ul>
                         <p class="wow alert row" data-wow-offset="50" data-wow-delay=".60s"> 
                            <strong style="color:black;font-size:17px">Our Location:</strong> &nbsp; <span class="gray-clr"> {{basic_information()->address}}</span> </p>
                    </div>

                    <div class="col-md-5 col-sm-6 col-md-offset-1 contact-form">
                        <div class="calculate-form">
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
                                   <i class="fa fa-check"></i> {{ session()->get('message') }}
                                </div>
                            @endif
                            <form class="row" id="contact-form" method="post">@csrf
                                <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">
                                    <div class="col-sm-3"> <label class="title-2"> Name: </label></div>
                                    <div class="col-sm-9"> <input type="text" name="name" id="Name" required value="{{old('name')}}" class="form-control"> </div>
                                </div>
                                <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">
                                    <div class="col-sm-3"> <label class="title-2"> Email: </label></div>
                                    <div class="col-sm-9"> <input type="text" name="email" id="Email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" value="{{old('email')}}" class="form-control"> </div>
                                </div>
                                <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">
                                    <div class="col-sm-3"> <label class="title-2"> Phone: </label></div>
                                    <div class="col-sm-9"> <input type="text" name="phone" id="Phone" value="{{old('phone')}}" class="form-control"> </div>
                                </div>
                                <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">
                                    <div class="col-sm-3"> <label class="title-2"> Message: </label></div>
                                    <div class="col-sm-9"> <textarea class="form-control" name="message" id="Message" required cols="25" rows="3">{{old('message')}}</textarea> </div>
                                </div>
                                <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">
                                    <div class="col-sm-9 col-xs-12 pull-right">
                                        <button id="submit_btn" class="btn-1"><i class="fa fa-send"></i> send message </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.Contact Us -->

        <!-- Contact Map -->
        <section class="map pt-80">
            <div class="map-canvas">
                <div id="map-canvas"></div>
            </div>
        </section>
        <!-- /.Contact Map -->

    </article>
@endsection
