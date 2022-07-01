<section class="calculate pt-100">
    <div class="theme-container container">
        <span class="bg-text right wow fadeInUp" data-wow-offset="50"data-wow-delay=".20s"> calculate </span>
        <div class="row">
            <div class="col-md-6 text-center">
                <img src="assets/img/block/Courier-Man.png" alt="" class="wow slideInLeft"
                     data-wow-offset="50" data-wow-delay=".20s"/>
            </div>
            <div class="col-md-6">
                <div class="pad-10"></div>
                <h2 class="section-title pb-10 wow fadeInUp" data-wow-offset="50" data-wow-delay=".20s">
                    calculate your cost </h2>
                <p class="fs-16 wow fadeInUp" data-wow-offset="50" data-wow-delay=".25s">Lorem ipsum dolor
                    sit amet, consectetuer adipiscing elit nonummy nibh
                    euismod tincidunt ut laoreet.</p>
                <div class="calculate-form">
                    <form class="row">
                        {{-- <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".20s">
                            <div class="col-sm-3"><label class="title-2"> height (cm): </label></div>
                            <div class="col-sm-9"><input type="text" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".20s">
                            <div class="col-sm-3"><label class="title-2"> width (cm): </label></div>
                            <div class="col-sm-9"><input type="text" placeholder="" class="form-control">
                            </div>
                        </div> --}}

                        <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".20s">
                            <div class="col-sm-3"><label class="title-2"> location: </label></div>
                            <div class="col-sm-9">
                                <?php $areas = \DB::table('areas')->get(); ?>
                                <div class="form-group">
                                    <select id="area" class="selectpicker form-control" data-live-search="true" data-width="100%"
                                            data-toggle="tooltip" title="select Area">
                                        @foreach($areas as $area)
                                        <option value="{{$area->id}}">{{$area->name}}</option> @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".20s">
                            <div class="col-sm-3"><label class="title-2"> weight (kg): </label></div>
                            <div class="col-sm-9"><input type="text" placeholder="Parcel weight in KG" class="form-control" id="weight">
                            </div>
                        </div>

                        <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".20s">
                            <div class="col-sm-3"><label class="title-2"> Delivery type </label></div>
                            <div class="col-sm-9">
                                <select id="delivery_type" class="selectpicker form-control">
                                    <option value="1">Regular</option>
                                    <option value="2">Express</option>
                                </select>
                            </div>
                        </div>
                       <!--  <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".20s">
                            <div class="col-sm-3"><label class="title-2"> location: </label></div>
                            <div class="col-sm-9">
                                <div class="col-sm-6 no-pad">
                                    <input type="text" placeholder="From" class="form-control from fw-600">
                                </div>
                                <div class="col-sm-6 no-pad">
                                    <input type="text" placeholder="To" class="form-control to fw-600">
                                </div>
                            </div>
                        </div> -->
                        
                        <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".20s">
                            <div class="col-sm-9 col-xs-12 pull-right">
                                <div class="btn-1"><span> Total Cost: </span> <span
                                    class="btn-1 dark" id="totalCost"> ... </span></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="pt-80 hidden-lg"></div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(function(){
    
        $('#area').change(function () {
            $('#totalCost').text('...');
            calculate();
        });
        $('#weight').keyup(function () {
            $('#totalCost').text('...');
            calculate();
        });
      
        $('.deliveryType').click(function () {
            $('#totalCost').text('...');
            calculate();
        });

        function calculate() {
            let area = $("#area").val();
            let weight = $("#weight").val();
            let delivery_type = $('#delivery_type').val();
            $.ajax({
                url: "{{ route('rate.check') }}",
                type: 'get',
                data: {
                    _token: CSRF_TOKEN,
                    area: area, weight: weight,
                    parcel_value: 0,
                    delivery_type: delivery_type
                },
                dataType: 'json',
                success: function (data) {
                    $('#submitMenu').removeClass('d-none');
                    if (data.status == 'error') {
                       alert(data.message);
                    }
                    if (data.status == 'success') {
                        $('#totalCost').text(data.total_price + ' Tk');
                    }
                }
            });
        }
    });
    </script>
