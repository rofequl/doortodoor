@if($banner !=null)
<section class="banner mask-overlay pad-120 white-clr">
    <div class="container theme-container rel-div">
        <img class="pt-10 effect animated fadeInLeft" alt="" src="assets/img/icons/icon-1.png"/>
        <ul class="list-items fw-600 effect animated wow fadeInUp" data-wow-offset="50"
            data-wow-delay=".20s">
            <li><a href="#">fast</a></li>
            <li><a href="#">secured</a></li>
            <li><a href="#">worldwide</a></li>
        </ul>
        <h2 class="section-title fs-48 effect animated wow fadeInUp" data-wow-offset="50"
            data-wow-delay=".20s"> {{$banner->title}}</h2>
    </div>
    <div class="pad-50 visible-lg"></div>
</section>

<style type="text/css">
    .banner{background: url(/{{$banner->photo}});}
</style>
@else
<section class="banner mask-overlay pad-120 white-clr">
    <div class="container theme-container rel-div">
        <img class="pt-10 effect animated fadeInLeft" alt="" src="assets/img/icons/icon-1.png"/>
        <ul class="list-items fw-600 effect animated wow fadeInUp" data-wow-offset="50"
            data-wow-delay=".20s">
            <li><a href="#">fast</a></li>
            <li><a href="#">secured</a></li>
            <li><a href="#">worldwide</a></li>
        </ul>
    </div>
    <div class="pad-50 visible-lg"></div>
</section>

@endif