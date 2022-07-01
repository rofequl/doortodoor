@extends('layouts.app')
@section('title','Pricing')
@section('content')
    <article>
        <!-- Product Delivery -->
        <section class="prod-delivery pad-100">
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

        <!-- Pricing & Plans -->
        @include('includes.pricing')
    </article>

    @include('includes.contact')
@endsection

