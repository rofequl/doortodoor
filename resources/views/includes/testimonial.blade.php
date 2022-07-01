<section class="testimonial mask-overlay">
    <div class="theme-container container">
        <div class="testimonial-slider no-pagination pad-120">
            <?php $testimonials = \DB::table('client_reviews')->where('status','1')->get(); ?>
            @foreach($testimonials as $test)
            <?php  if($test->photo==null) $src= 'images/user.png';
            else $src= $test->photo; ?>
            <div class="item">
                <div class="testimonial-img darkclr-border theme-clr font-2 wow fadeInUp"
                     data-wow-offset="50" data-wow-delay=".20s">
                    <img alt="" src="/{{$src}}"/>
                    <span>,,</span>
                </div>
                <div class="testimonial-content">
                    <p class="wow fadeInUp" data-wow-offset="50" data-wow-delay=".25s"><i
                            class="gray-clr fs-16">
                            {{$test->comment}}
                        </i></p>
                    <h2 class="title-2 pt-10 wow fadeInUp" data-wow-offset="50" data-wow-delay=".20s"><a
                            href="#" class="white-clr fw-900"> {{$test->commenter}}</a></h2>
                </div>
            </div>@endforeach
        </div>
    </div>
</section>