@extends('layouts.app')

@section('content')
    <article>
        <!-- Breadcrumb -->
        <section class="theme-breadcrumb pad-50">
            <div class="theme-container container ">
                <div class="row">
                    <div class="col-sm-8 pull-left">
                        <div class="title-wrap">
                            <h2 class="section-title no-margin"> product tracking </h2>
                            <p class="fs-16 no-margin"> Track your product & see the current condition </p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb-menubar list-inline">
                            <li><a href="#" class="gray-clr">Home</a></li>
                            <li class="active">Track</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Tracking -->
        <section class="pt-50 pb-120 tracking-wrap">
            <div class="theme-container container ">
                <div class="row pad-10">
                    <div class="col-md-8 col-md-offset-2 tracking-form wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">
                        <h2 class="title-1"> track your product </h2> <span class="font2-light fs-12">Now you can track your product easily</span>
                        <div class="row">
                            <form action="/track-shipment" method="get" id="trackForm">@csrf
                                <div class="col-md-7 col-sm-7">
                                    <div class="form-group">
                                        <input type="text" placeholder="Enter your product ID" name="tracking_code" required="" class="form-control box-shadow">
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-5">
                                    <div class="form-group">
                                        <button class="btn-1">track your product</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="get-tracking"></div>
            </div>
        </section>
    </article>

@endsection
@push('script')
@if(request()->code)
    <script>
        $('.get-tracking').html('Processing...');
        $.ajax({
            type: "get", url: '/track-shipment',data: {tracking_code:<?php echo request()->code;?>}, 
            success: function(data){
                $('.get-tracking').html(data);
            }
        });
    </script>
@endif
<script>
    $(function(){
        $("#trackForm").submit(function(e) {
            e.preventDefault(); 
            $('.get-tracking').html('Processing...');
            var form = $(this); var url = form.attr('action');
            $.ajax({
               type: "get", url: url,data: form.serialize(), 
               success: function(data){
                  $('.get-tracking').html(data);
               }
            });
        });
    })
</script>
@endpush