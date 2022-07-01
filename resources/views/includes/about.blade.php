@if($about !=null)
<section class="pad-80 about-wrap clrbg-before">
    <span class="bg-text wow fadeInUp" data-wow-offset="50" data-wow-delay=".20s"> {{$about->title}} </span>
    <div class="theme-container container">
        <div class="row">
            <div class="col-md-12">
                <div class="about-us">
                    <h2 class="section-title pb-10 wow fadeInUp" data-wow-offset="50" data-wow-delay=".20s"> {{$about->title}} </h2>
                    <div class="fs-16 wow fadeInUp" data-wow-offset="50" data-wow-delay=".25s">
                        {!! $about->description !!}
                    </div>
                    >
                </div>
            </div>
        </div>
    </div>
</section>

@endif