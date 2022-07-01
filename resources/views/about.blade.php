@extends('layouts.app')

@section('content')
    <article class="about-page">
        <!-- Breadcrumb -->
        <section class="theme-breadcrumb pad-50">
            <div class="theme-container container ">
                <div class="row">
                    <div class="col-sm-8 pull-left">
                        <div class="title-wrap">
                            <h2 class="section-title no-margin">About us</h2>
                            <p class="fs-16 no-margin">Know about us more</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb-menubar list-inline">
                            <li><a href="#" class="gray-clr">Home</a></li>
                            <li class="active">About</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Us -->
        @include('includes.about')

        <!-- More About Us -->
        <section class="pad-30 more-about-wrap">
            <div class="theme-container container pb-100">
                <div class="row">
                    @foreach($abouts as $key=>$row)
                    <div class="col-md-4 col-sm-4 wow fadeInUp" data-wow-offset="50" data-wow-delay=".{{$key+1}}0s">
                        <div class="more-about clrbg-before">
                            <h2 class="title-1">{{$row->title}}</h2>
                            <div class="pad-10"></div>
                            <p> @if(strlen($row->description) >315)
                                    {{substr($row->description,0,315)}} ...
                                @else {{$row->description}} @endif </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </article>
@endsection
