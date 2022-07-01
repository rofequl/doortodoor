@extends('admin.layout.app')
@section('title','Employee information')
@section('content')
    <div class="right_col" role="main">
        <div class="col-md-12">
            <form id="upload_form" method="post" action="">
                {{csrf_field()}}
                @foreach(\Session::get('csv_data') as $key=>$line)

                <div class="page"><b>Parcel: {{$key+1}}</b></div>

                <div class="form_each">
                    <div class="form-row">
                        <div class="col-md-4 text-left">
                            <label class="" for="name">Customer Name</label>
                            <input type="text" id="name" class="form-control" name="name[]" value="{{$line['customer']}}" required>
                        </div>
                        <div class="col-md-4 text-left">
                            <label for="usr3">Phone Number</label>
                            <input type="text" class="form-control" name="phone[]" value="{{$line['contact']}}" required>
                        </div>
                        <div class="col-md-4 text-left">
                            <label class="" for="address">Address</label>
                            <input type="text" id="address" class="form-control" name="address[]" value="{{$line['address']}}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        
                        <div class="col-md-3 text-left">
                            <label for="zip_code">Zip Code</label>
                            <input type="text" id="zip_code" class="form-control" name="zip_code[]" value="{{$line['post_code']}}">
                        </div>
                        <div class="col-md-3 text-left">
                            <label class="" for="weight">Weight</label>
                            <input type="text"  class="form-control weight" data-key="{{$key}}" name="weight[]" id="weight{{$key}}" value="1">
                           
                        </div>
                        <div class="col-md-3 cod_target text-left">
                            <label for="parcel_value">Declared Parcel Value</label>
                            <input type="number" class="form-control parcel_value" data-key="{{$key}}" name="parcel_value[]" id="parcel_value{{$key}}" value="{{$line['price']}}">
                           
                        </div>
                        <div class="col-md-3 text-left">
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
                            <select class="form-control select2 area" data-key="{{$key}}" name="area[]" id="area{{$key}}" required style="padding:1px;">
                                <option value="" selected disabled>Select area</option>
                                @foreach($areas as $area)
                                    <option value="{{$area->id}}">{{$area->name}}</option>
                                @endforeach
                            </select> 
                        </div>

                        <div class="col-md-7 text-left">
                            <label for="merchant_note">Merchant note</label>
                            <input type="text" id="merchant_note" class="form-control" name="merchant_note[]">
                        </div>
                    </div>
                  
                </div>
                @endforeach  <br>
                <div class="form_each"> <br>
                    <div class="form-row">
                        <div class="col-md-4">
                            <?php $merchants = \DB::table('users')->get(); ?>
                            <select name="user_id" class=" select2 form-control" required="">
                               @foreach($merchants as $merchant)
                                <option value="">Select Merchant</option>
                                <option value="{{$merchant->id}}">{{$merchant->first_name.' '.$merchant->last_name}}</option> @endforeach
                            </select>

                        </div>
                        <div class="col-md-4">
                            <select name="type" class="select2 form-control">
                                <option value="" >Shipment type</option>
                                <option value="0" selected="">Pickup</option>
                                <option value="2">Receive</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" onclick="working()" class="submit mt-2 px-4 btn btn-success pull-right"> <b class="fa fa-send"> Save shipment Sheet</b>  </button>
                        </div>
                    </div>  
                    
                </div>
            </form><br>
        </div>
    </div>
@endsection
@push('style')
    
    <link rel="stylesheet" href="{{asset('vendors/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/select2/dist/css/bootstrap4-select2.css')}}">
     <style type="text/css">
    .form_each{ background: #e0f3ff;padding: 2%; border:1px solid ;width: 100%;float:left;}
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
        top: 19px; left: 0;color: #467100;    float: left;
        width: 100%;
    }
    .page b{text-align: left}
    .area{border:1px solid silver;}
    </style>
@endpush
@push('scripts')
   
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
      $(".select2").select2({
          placeholder: "Select one",
          allowClear: true
      });

    </script>

@endpush
