<section>
    <div class="theme-container container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 track-prod clrbg-before wow slideInUp" data-wow-offset="50"
                 data-wow-delay=".20s">
                <h2 class="title-1"> track your product </h2> <span class="font2-light fs-12">Now you can track your product easily</span>
                <div class="row">
                    <form action="/track-shipment" method="get" id="trackForm">@csrf
                        <div class="col-md-7 col-sm-7">
                            <div class="form-group">
                                <input type="text" placeholder="Tracking code" required="" name="tracking_code" class="form-control box-shadow">
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
        </div> <br>
        <div class="get-tracking"></div>
    </div>
    </section>