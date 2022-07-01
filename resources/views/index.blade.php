@extends('layouts.app')

@section('content')
    <article>
        <!-- Banner/Slider portion -->
        @include('includes.banner')
        
        <!-- Track Product -->
        @include('includes.tracking-form')

        <!-- About Us -->
        @include('includes.about')
        
        <!-- Calculate Your Cost -->
        @include('includes.calculate-cost')

        <!-- Steps -->
        <section class="steps-wrap mask-overlay pad-80">
            <div class="theme-container container">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="font-2 fs-50 wow fadeInLeft" data-wow-offset="50" data-wow-delay=".20s"> 1.
                        </div>
                        <div class="steps-content wow fadeInLeft" data-wow-offset="50" data-wow-delay=".25s">
                            <h2 class="title-3">Order</h2>
                            <p class="gray-clr">Order us for a <br>delivery you want</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="font-2 fs-50 wow fadeInLeft" data-wow-offset="50" data-wow-delay=".20s"> 2.
                        </div>
                        <div class="steps-content wow fadeInLeft" data-wow-offset="50" data-wow-delay=".25s">
                            <h2 class="title-3">Wait</h2>
                            <p class="gray-clr">Wait for some hours, <br> Our man on the way</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="font-2 fs-50 wow fadeInLeft" data-wow-offset="50" data-wow-delay=".20s"> 3.
                        </div>
                        <div class="steps-content wow fadeInLeft" data-wow-offset="50" data-wow-delay=".25s">
                            <h2 class="title-3">Deliver</h2>
                            <p class="gray-clr">Within the day <br> we will reach to you</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="step-img wow slideInRight" data-wow-offset="50" data-wow-delay=".20s"><img
                    src="assets/img/block/step-img.png" alt=""/></div>
        </section>
        <!-- /.Steps -->

        <!-- Product Delivery -->
        <section class="prod-delivery pad-120">
            <div class="theme-container container">
                <div class="row">
                    <div class="col-md-11 col-md-offset-1">
                        <div class="pt-120 rel-div">
                            <div class="pb-50 hidden-xs"></div>
                            <h2 class="section-title wow fadeInUp" data-wow-offset="50" data-wow-delay=".20s"> Get
                                the <span class="theme-clr"> fastest </span> product delivery </h2>
                            <p class="fs-16 wow fadeInUp" data-wow-offset="50" data-wow-delay=".25s">Lorem ipsum
                                dolor sit amet, consectetuer adipiscing elit, sed diam <br>
                                nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam <br>
                                erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci <br>
                                tation ullamcorper suscipit lobortis nisl ut aliquip.</p>
                            <div class="pb-120 hidden-xs"></div>
                        </div>
                        <div class="delivery-img pt-10">
                            <img alt="" src="assets/img/block/delivery.png" class="wow slideInLeft"
                                 data-wow-offset="50" data-wow-delay=".20s"/>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.Product Delivery -->

        <!-- Testimonial -->
        @include('includes.testimonial')
        
        <!-- Pricing & Plans -->
        @include('includes.pricing')

        <!-- Contact us -->
       
    </article>
@endsection
@push('loader')
    <div id="preloader">

        <div class="small1">
            <div class="small ball smallball1"></div>
            <div class="small ball smallball2"></div>
            <div class="small ball smallball3"></div>
            <div class="small ball smallball4"></div>
        </div>


        <div class="small2">
            <div class="small ball smallball5"></div>
            <div class="small ball smallball6"></div>
            <div class="small ball smallball7"></div>
            <div class="small ball smallball8"></div>
        </div>

        <div class="bigcon">
            <div class="big ball"></div>
        </div>

    </div>
@endpush

@push('script')
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