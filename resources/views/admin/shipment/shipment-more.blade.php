@extends('admin.layout.app')
@section('title','Merchant List')
@section('content')
    <div class="right_col" role="main">
        <div style="margin-top:1em">
            <div class="row">
                <div class="panel panel-primary">
                  <div class="panel-heading">Marchant information</div>
                  <div class="panel-body">
                    <div class="col-md-2">
                        <img src="{{$user->image == null? asset('images/user.png'):asset('storage/user/'.$user->image)}}" style="max-width:100%;max-height:160px" class="img-rounded" alt="{{$user->first_name}}">
                    </div>
                    <div class="col-md-10 text-capitalize">
                       <b>Name:</b> {{$user->first_name}} {{$user->last_name}} 
                       &nbsp; &nbsp; &nbsp; <b>Shop Name:</b> {{$user->shop_name}}<hr/>
                        <b>Phone:</b> {{$user->phone}} &nbsp; &nbsp; &nbsp; 
                        <b>Email:</b> {{$user->email}}<hr>
                        <b>Address:</b> {{$user->address}}
                    </div>
                  </div>
                </div>
                <div class="page-title">
                    <h3>Merchant Shipment List 
                        @if($shipments->count()>0 && Request::segment(6)=='0')
                        <a data-target="#assignShipment" data-toggle="modal" data-id="all" href="#" class="btn btn-primary assign pull-right">Assign all parcels to a Rider</a> @endif
                    </h3>
                </div>
                @if(session()->has('message'))
                    <div class="alert alert-success alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="clearfix"></div>
            
                <div class="x_panel">
                    <div class="x_content table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline">
                            <thead>
                            <tr class="bg-dark">
                                <th>#SL 
                                    <!-- <input id="checkAll" type="checkbox" name="checkAll"> -->
                                </th>
                                 <th>Customer Info</th><th>Area</th>
                                <th>Customer Contact</th> <th>Delivery Type</th><th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($shipments as $key=>$shipment)
                                <tr>
                                    <th scope="row">
                                        <input style="display:none" type="checkbox" id="ids" name="ids[]" value="{{$shipment->id}}"> {{$key+1}}</th>


                                    <th scope="row">Name: {{$shipment->name}} <br>Price: {{$shipment->price}}
                                    </th>
                                    <th scope="row">
                                        Zone: {{$shipment->zone->name}} <br>
                                        Area: {{$shipment->area->name}} 
                                    </th>
                                    <th scope="row"><i class="fa fa-phone"></i> {{$shipment->phone}}<br>

                                    <i class="fa fa-map-marker"></i> {{$shipment->address}}<br>
                                    </th>
                                     <th scope="row">
                                        @if($shipment->delivery_type=='1') Regular
                                        @else Express @endif
                                    </th>

                                    <th class="text-right">
                                        @if($shipment->status=='1' && $shipment->shipping_status <2)
                                        <a onClick="return confirm('Are you sure to Delete the shipment');" href="/admin/delete-shipment/{{$shipment->id}}" class="btn-xs btn btn-danger"><i class="fa fa-trash"></i> Delete</a>
                                        <a data-id="{{$shipment->id}}" data-toggle="modal" data-target="#cancelNote" href="#" class="btn-xs btn btn-warning cancel"><i class="fa fa-times"></i> Cancel</a>

                                        @elseif($shipment->status=='2')
                                            cancelled
                                        @else
                                        
                                        @endif
                                        <!-- <a href="#" class="btn btn-primary btn-xs assign" data-toggle="modal" data-target="#assignShipment" data-id="{{$shipment->id}}">to Driver <i class="fa fa-truck"></i></a> -->
                                    </th>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Modal to assign to driver -->
<div id="assignShipment" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Assign all parcels to a Rider</h4>
      </div>
      <div class="modal-body">
        <form method="post">@csrf
            @include('admin.shipment.includes.shipment-assign-driver-form')
            <input type="hidden" name="shipment_id" id="shipment_id"> <br>
            <button type="submit" class="pull-right btn btn-info btn-sm"> <i class="fa fa-truck"></i> Assign to pick parcels</button>
        </form>
      </div>
    </div>

  </div>
</div>

<!-- Modal cancelling note-->
<div class="modal fade" id="cancelNote" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form id="cancelForm" class="modal-content">@csrf
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cancel Note
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></h5>
      </div>
      <div class="modal-body">
        <label>Cancelling note (if any)</label>
        <textarea class="form-control" rows="3" name="note"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Cancel the Shipment</button>
      </div>
    </form>
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
    <script type="text/javascript">
        $(function(){
             $('#checkAll').click(function () {    
                 $('input:checkbox').prop('checked', this.checked);    
             });

            $('.assign').on('click',function(){
                let id = $(this).data('id');
                $('#shipment_id').val(id);

                if(id=='all'){
                    var searchIDs = $("#datatable-buttons input:checkbox").map(function(){
                        return $(this).val();
                    }).toArray();
                    $('#shipment_id').val(searchIDs);
                    // if(searchIDs==''){
                    //     alert('Please check some Merchant/s ');
                    //     $('#assignShipment').modal().hide();
                    // }
                }
            });

            $('.cancel').on('click',function(){
                let id = $(this).data('id');
                $('#cancelForm').attr('action','/admin/cencell-shipment/'+id)
            });
        })
    </script>

@endpush
