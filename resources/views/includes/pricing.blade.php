<section class="pricing-wrap pb-100">
    <div class="theme-container container">
            <span class="bg-text center wow fadeInUp" data-wow-offset="50"
                  data-wow-delay=".20s"> Pricing </span>
        <div class="title-wrap text-center  pb-50">
            <h2 class="section-title wow fadeInUp" data-wow-offset="50" data-wow-delay=".20s">Pricing &
                plans</h2>
            <p class="wow fadeInLeft" data-wow-offset="50" data-wow-delay=".25s">See our pricing & plans to
                get best service</p>
        </div>
        <div class="row">
            <?php $prices = \App\ShippingPrice::all(); ?>
            @foreach($prices as $price)
            <div class="col-md-4 wow slideInUp" data-wow-offset="50" data-wow-delay=".20s">
                <div class="pricing-box clrbg-before clrbg-after transition">
                    <div class="title-wrap text-center">
                        <h2 class="section-title fs-36">&#2547; {{$price->price}}</h2>
                        <p>for @if($price->delivery_type=='1')Regular @else Express @endif delivery</p>
                        <div class="btn-1">{{$price->zone->name}}</div>
                    </div>
                    <div class="price-content">
                        <ul class="title-2">
                            <li> Product Weight: <span class="gray-clr">&LT; {{$price->max_weight}}kg</span></li>
                            <li> COD: <span class="gray-clr"> @if($price->cod==0) <small>No COD applied</small>  @else <small>Applied</small> @endif </span></li>
                            <li> COD Amount: <span class="gray-clr"> @if($price->cod_value==null) <small>Not applied</small> @else {{$price->cod_value}} Tk @endif </span></li>
                            <li> support: <span class="gray-clr">yes</span></li>
                        </ul>
                    </div>
                    <div class="order">
                        <a href="javaScript:;" class="title-1 theme-clr"> <span class="transition"> order now </span>
                            <i class="arrow_right fs-26"></i> </a>
                    </div>
                    <div class="pricing-hover clrbg-before clrbg-after transition"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
