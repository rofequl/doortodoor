@extends('driver.layout.app')
@section('title','My shipment List')
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left"><h3>My Shipment List</h3></div>
        </div>
        <div class="clearfix"></div>
        <hr>
        @if(session()->has('message'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="x_panel">
                    <div class="x_content">
                        <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline">
                            <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <th>Customer info</th>
                                <th>Address</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($paracels as $key=>$row)
                                <tr><td>{{$key+1}}</td>
                                    <td>Name: {{$row->shipment->name}} <br>
                                        Phone: {{$row->shipment->phone}}</td>
                                    <td>Area: {{$row->shipment->area->name}} <br>
                                       Address: {{$row->shipment->address}}
                                    </td>
                                    <td> 
                                       @if($row->shipment->price==0) Pay by merchant @else Pay by customer @endif
                                        <br>
                                        Payable: ( {{$row->shipment->price}} )
                                    </td>
                                    <td class="text-right">
                                        <button class="btn btn-info btn-sm more" data-id="{{$row->shipment->id}}">More info</button>
                                        <button class="btn btn-success btn-sm report" data-price="{{$row->shipment->price}}" data-id="{{$row->id}}">Delivery Report</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


  <!-- Modal for more-info -->
  <div class="modal fade" id="moreView" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Parcel details</h4>
        </div>
        <div class="modal-body details"> </div>
      </div>
    </div>
  </div>

  <!-- Modal for reporting-->
  <div class="modal fade" id="reportModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Parcel Delivery Report</h4>
        </div>
        <div class="modal-body"> 
            @include('driver.shipment.includes.driver-report-form')
        </div>
      </div>
    </div>
  </div>

@endsection
@push('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
    <!-- Datatables -->
    <link href="{{asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}"
          rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}"
          rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
@endpush

@push('scripts')
    <!-- Datatables -->
    <script src="{{asset('vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
    <script src="{{asset('vendors/jszip/dist/jszip.min.js')}}"></script>
    <script src="{{asset('vendors/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{asset('vendors/pdfmake/build/vfs_fonts.js')}}"></script>
    <script>
        $(function(){
            //visible price field if delivery report is partially deliverd
            jQuery('[name=status]').change(function() {
                if ($(this).prop('checked') && $(this).val()=='partial') {
                   $('.pirceArea').slideDown();
                }else $('.pirceArea').slideUp();

                if( $(this).val() =='hold' || $(this).val() =='delivered'){
                    $('.otpArea').hide();
                    $('[name=otp]').prop('required',false);
                }else {
                    $('.otpArea').show();
                    $('[name=otp]').prop('required',true);
                }
            });
            $('.more').on('click',function(){
                let id = $(this).data('id');
                $('#moreView').modal('show');
                $('.details').html('Loading....');
                $.ajax({
                   type: "get",url: '/driver/shipment-info/'+id,
                   success: function(data){$('.details').html(data);}
                });
            });

            $('.report').on('click',function(){
                let id = $(this).data('id');
                let price = $(this).data('price');
                $('#reportModal').modal('show');
                $('[name=id]').val(id);
                $('[name=price]').val(price);
                // alert(price);return false;
                if(price=='0'){
                    $('.otpArea').show();
                    $('[name=otp]').prop('required',true);
                }else{
                    $('[name=otp]').prop('required',false);
                    $('.otpArea').hide();
                }
            });

            $("#reportSubmitT").submit(function(e) {
                e.preventDefault(); var form = $(this); var url = form.attr('action');
                $('[type=submit]').html('Working...');
                $.ajax({
                    type: "POST", url: url, data: form.serialize(),
                    success: function(data){  
                        $('[type=submit]').html('<i class="fa fa-send"></i> Submit Report');
                        $('.result').html(data);
                        if(data=='success'){
                            alert("Your Report has been saved successfully!");
                            location.reload();
                        }
                    }
                });
            });
            
        })
    </script>

@endpush
