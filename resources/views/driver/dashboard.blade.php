@extends('driver.layout.app')

@section('content')
    <?php if(request()->r=='') $type='delivery'; else $type=request()->r;?>

    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    @if(session()->has('message'))
                        <div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <div class="x_title">
                        <h2><i class="fa fa-truck"></i> <small>My Shipments tabe</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <ul class="nav nav-tabs">
                            <li class="nav-item  @if($type=='pickup')active @endif">
                                <a class="nav-link" href="/driver?r=pickup">All Pick-Up</a>
                            </li>
                            <li class="nav-item @if($type=='delivery')active @endif">
                                <a class="nav-link" href="/driver?r=delivery">All Delivery</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="search-tab" data-toggle="tab" href="#search" role="tab" aria-controls="search" aria-selected="false">Search Shipments</a>
                            </li>
                            <li class="nav-item  @if($type=='otp')active @endif">
                                <a class="nav-link" href="/driver?r=otp">Confirm Delivery</a>
                            </li>
                        </ul>
                        <div class="tab-content"> <br>
                            <div class="tab-pane fade" id="search" role="tabpanel" aria-labelledby="search-tab">
                                <div class="control-group ">
                                    <div class="controls row">
                                        <div class="col-md-6">
                                            <div class="input-prepend input-group">
                                                <span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" id="reservation" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-prepend input-group">
                                                <span class="add-on input-group-addon"><i class="fa fa-check"></i></span>
                                                <div class="form-control">
                                                    
                                                <label class="radio-inline"><input type="radio" name="type" value="delivery">Delivery Shipment
                                                    </label>
                                                <label class="radio-inline"><input type="radio" name="type" value="pickup">Pickup Shipments</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-primary form-control" id="GoSearch"><i class="fa fa-search"></i> GO</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                        <table id="datatable"class="table table-striped table-bordered no-footer dtr-inline">
                            <thead>
                                <tr class="bg-dark">
                                    <th>Date</th>  <th>Customer info</th>
                                    <th>Merchant</th><th>Amount</th>
                                    <th>Area</th> <th>status</th>
                                </tr>
                            </thead>
                          
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


<div class="modal fade otpModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Set shipment OPT Code
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button> </h5>
          </div>
          <div class="modal-body">
              <form  method="post" action="/driver/confirm-otp">@csrf
                <div class="control-group ">
                    <div class="controls row">
                        <div class="col-md-6 col-xs-6">
                            <input type="text" placeholder="Type OTP" class="form-control" name="otp">
                            <input type="hidden" id="shipment_id" name="shipment_id">
                        </div>
                        <div class="col-md-4 col-xs-6">
                            <select name="collect_by" class="form-control">
                                <option value="">Collect From</option>
                                <option value="merchant">Merchant</option>
                                <option value="customer">Customer</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-xs-5">
                            <button class="btn btn-primary form-control"><i class="fa fa-check"></i></button>
                        </div>
                    </div>
                </div>
              </form>
          </div>
      </div>
    </div>
</div>
  
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
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $(function(){
            // get data
            $(function () { table.ajax.reload(); });
            let table = $('#datatable').DataTable({
                processing: true,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only"></span>'
                },
                serverSide: true,ajax: "/driver/get-shipments/<?php echo $type;?>",
                order: [ [0, 'desc'] ],
                columns: [
                    {data: 'date'}, {data: 'customer_info'},
                    {data: 'merchant'}, {data: 'amount'},
                    {data: 'area'}, {data: 'status',orderable: false, searchable: false, class:'text-right'},
                ]
            });

            $('#datatable').on('click', '.openModal',function(e){
                let id = $(this).attr('id')
                $('.otpModal').modal('show');
                $('#shipment_id').val(id);
            });

            $('#GoSearch').on('click',function() {
                var dates = $('#reservation').val();
                var type = $('[name=type]:checked').val();

                if( $('[name=type]').is(':checked') ===false){
                    alert('Please check a shipment type & proceed!!');return false;
                }
                var newDates=replaceAll(dates,"/","~"); 
                $('#datatable').html('Loading.....');
                $.ajax({
                    type: 'get',url: '/driver/get-shipments-with-dates/'+newDates+'/'+type,
                    success: function (data) {$('#datatable').html(data);},
                    error: function (data) {
                        console.log('An error occurred.');
                    },
                });
            });
   

            function replaceAll(str, find, replace) {
                var escapedFind=find.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
                return str.replace(new RegExp(escapedFind, 'g'), replace);
            }
        })
    </script>

@endpush