@extends('dashboard.layout.app')
@section('pageTitle','Prepare Shipment')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fa fa-file-excel-o text-success" aria-hidden="true"></i>
                </div>
                <div>Edit csv-file data
                    <div class="page-title-subheading">Check all the file data and update
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-content">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{$error}}
                </div>
            @endforeach
        @endif
        @if(session()->has('message'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session()->get('message') }}
            </div>
        @endif
        
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-3 card card-body">
                <form id="upload_form" method="post" action="">
                    {{csrf_field()}}
                    @foreach(\Session::get('csv_data') as $key=>$line)
                    <div class="page">Parcel: {{$key+1}}</div>
                    <div class="form_each">
                        <div class="form-row">
                            <div class="col text-left">
                                <label class="" for="name">Customer Name</label>
                                <input type="text" id="name" class="form-control" name="name[]" value="{{$line['customer']}}" required>
                            </div>
                            <div class="col text-left">
                                <label for="usr3">Phone Number</label>
                                <input type="text" class="form-control" name="phone[]" value="{{$line['contact']}}" required>
                            </div>
                            <div class="col text-left">
                                <label class="" for="address">Address</label>
                                <input type="text" id="address" class="form-control" name="address[]" value="{{$line['address']}}" required>
                            </div>
                        </div>
                        <div class="form-row">
                            
                            <div class="col text-left">
                                <label for="zip_code">Zip Code</label>
                                <input type="text" id="zip_code" class="form-control" name="zip_code[]" value="{{$line['post_code']}}">
                            </div>
                            <div class="col text-left">
                                <label class="" for="weight">Weight</label>
                                <input type="text"  class="form-control weight" data-key="{{$key}}" name="weight[]" id="weight{{$key}}" value="1">
                               
                            </div>
                            <div class="col cod_target text-left">
                                <label for="parcel_value">Declared Parcel Value</label>
                                <input type="number" class="form-control parcel_value" data-key="{{$key}}" name="parcel_value[]" id="parcel_value{{$key}}" value="{{$line['price']}}">
                               
                            </div>
                            <div class="col text-left">
                                <label for="invoice_id">Invoice Id</label>
                                <input type="text" id="invoice_id" class="form-control" name="invoice_id[]" value="{{$line['invoice']}}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-2 text-left">
                                <label for="invoice_id">Shipping method</label>
                                <select class="form-control" name="delivery_type[]" required style="padding:1px;">
                                    <option value=""  disabled>Select Delivery type</option>
                                    <option value="1" selected>Regualr</option>
                                    <option value="2">Express</option>
                                </select> 
                            </div>
                            <div class="col-md-3 text-left">
                                <label for="area">Area</label>
                                <select class="form-control select2 area" data-key="{{$key}}" name="area[]" id="area{{$key}}" style="padding:1px;" required="">
                                    <option value="" selected disabled>Select area</option>
                                    @foreach($areas as $area)
                                        <option value="{{$area->id}}">{{$area->name}}</option>
                                    @endforeach
                                </select> 
                            </div>

                            <div class="col text-left">
                                <label for="merchant_note">Merchant note</label>
                                <input type="text" id="merchant_note" class="form-control" name="merchant_note[]">
                            </div>
                        </div>
                      
                    </div>
                    @endforeach <br>
                 
                    <button type="submit" onclick="working()" class="submit mt-2 px-4 btn btn-success float-left"> <b class="fa fa-send"> Save the Sheet</b>
                    </button> <br>
                </form><br>
            </div>
        </div>
    </div>





@push('style')
    <style type="text/css">
    .form_each{ background: #e0f3ff;padding: 2%; border:1px solid ;}
    #NotFound1{border:2px solid red;}
    .activating { background-color: #295b35;color: white;}
    .activating2 {border: 1px solid red !important;}
    .card-body { padding: 0.3rem;}
    .form-control{font-size: 12px;height: 25px;}
    .select2-container {background: white;height: 25px;}
    .card-title { margin-bottom: 0; }
    .mt-4, .my-4 { margin-top: 0;}
    label {font-size: 12px;margin-bottom: 0px;}
    .page {
        position: relative; background: #e0f3ff;
        padding: inherit;border: 1px solid silver;
        width: 96px; height: 26px; text-align: center;
        top: 19px; left: 0;color: #467100;
    }
    .area{border:1px solid silver;}
    .select2-selection--single {border-bottom: 0px}
    </style>
    <link href="{{asset('vendors/sweetalert/sweetalert.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('vendors/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/select2/dist/css/bootstrap4-select2.css')}}"> 
@endpush

@endsection

@push('script')
    <script src="{{asset('vendors/sweetalert/sweetalert.js')}}"></script>
    <script src="{{asset('vendors/select2/dist/js/select2.min.js')}}"></script>
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function () {
            $('.select2').select2({
                theme: "bootstrap",
                width: '100%'
            });
            $('.area').change(function () {
                var key= $(this).data('key');
                calculate(key);
            });
            $('.weight').keyup(function () {
                var key= $(this).data('key');
                let id = parseFloat($(this).val());
                $('.weight_info'+key).text(id.toFixed(2));
                calculate(key);
            });

            $('.parcel_value').keyup(function () {
                var key= $(this).data('key');
                let id = parseInt($(this).val());
                $('.parcel_value_info'+key).text(id);
                calculate(key);
            });
            $('.deliveryType').on('click',function () {
                var key= $(this).data('key');
                $('#deliveryType'+key).val($(this).attr('id'));
                
                if ( $(this).data('type')=='express' ) {
                    $('.express').css('border','1px solid red');
                    $('.regular').css('border','1px solid silver');
                }else{
                    $('.regular').css('border','1px solid red');
                    $('.express').css('border','1px solid silver');
                }

                $('.deliveryType').removeClass('activating2');
                $(this).addClass('activating2');
                calculate(key);
            });
        });


        function calculate(key) {
            // alert(key);return false;
            let area = $("#area"+key).val();
            let weight = $("#weight"+key).val();
            let parcel_value = $("#parcel_value"+key).val();
            let delivery_type = $("#deliveryType"+key).val();
            // alert(delivery_type);
            $.ajax({
                url: "{{ route('merchant.rate.check') }}",
                type: 'post',
                data: {
                    _token: CSRF_TOKEN,
                    area: area,
                    weight: weight,
                    parcel_value: parcel_value,
                    delivery_type: delivery_type
                },
                dataType: 'json',
                success: function (data) {
                    $('#submitMenu'+key).removeClass('d-none');
                    if (data.status == 'error') {
                        $('#NotFound'+key).removeClass('d-none');
                        $('#FoundPrice'+key).addClass('d-none');
                        $('#error_message'+key).text('Note : ' + data.message);
                    }

                    if (data.status == 'success') {
                        $('#FoundPrice'+key).removeClass('d-none');
                        $('#NotFound'+key).addClass('d-none');
                        $('#PriceShowing'+key).text(data.total_price + ' Taka');
                        if (data.cod == 1) {
                            $('.codHas'+key).show();
                            $('#NotFoundState1'+key).text('Price + ' + data.cod_rate + '% COD');
                            $('#NotFoundState21'+key).text(data.price + ' + ' + data.cod_amount);
                        } else $('.codHas'+key).hide();
                    }
                }
            });

            //alert(zone);
        }

    </script>

@endpush