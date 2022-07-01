@extends('driver.layout.app')
@section('title',' shipments of '.$user->first_name)
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
                        @if($shipments->count()>0)
                        <a href="/driver/receive-all-shipment/{{$user->id}}" class="btn btn-primary pull-right">Receive All Parcels</a> @endif
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
                                 <th>Customer Info</th>
                                 <th>Area</th>
                                <th>Customer Contact</th> <th>Delivery Type</th> <th>Status</th> <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($shipments as $key=>$row)
                                <tr>
                                    <th scope="row">
                                        <input style="display:none" type="checkbox" id="ids" name="ids[]" value="{{$row->shipment->id}}"> {{$key+1}}</th>
                                    <th scope="row">Name: {{$row->shipment->name}} <br>Price: {{$row->shipment->price}}
                                    </th>
                                    <th scope="row">
                                        Zone: {{$row->shipment->zone->name}} <br>
                                        Area: {{$row->shipment->area->name}} 
                                    </th>
                                    <th scope="row"><i class="fa fa-phone"></i> {{$row->shipment->phone}}<br>

                                    <i class="fa fa-map-marker"></i> {{$row->shipment->address}}<br>
                                    </th>
                                     <th scope="row">
                                        @if($row->shipment->delivery_type=='1') Regular
                                        @else Express @endif
                                    </th>

                                    <th scope="row">
                                        @include('admin.shipment.status',
                                        ['status'=>$row->shipment->status,'shipping_status'=>$row->shipment->shipping_status])
                                    </th>
                                   
                                    <th class="text-right">
                                        <a onClick="return confirm('Are you sure to receive the shipment');" href="/driver/receive-shipment/{{$row->shipment->id}}" class="btn-xs btn btn-success"><i class="fa fa-check"></i> Receive</a>

                                        <a data-toggle="modal" data-target="#cancelParcel" data-id="{{$row->shipment->id}}" class="btn-xs btn btn-warning cencel"><i class="fa fa-times"></i> Cancell</a>
                                       
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



<!-- Modal to cencell -->
<div class="modal fade" id="cancelParcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="modal-content" id="cancelForm">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cencell notes
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></h5>
        
      </div>
      <div class="modal-body">
        @csrf
        <div class="form-group">
            <label for="exampleFormControlInput1">Note (if any)</label>
            <textarea class="form-control" name="note" placeholder="note" rows="4"></textarea>
        </div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Cencell Parcel</button>
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
   
<script type="text/javascript">
    $(function(){
        $('.cencel').on('click',function(){
            let id = $(this).data('id');
            $('#cancelForm').attr('action','/driver/cencell-parcel/'+id)
        });
    })
</script>
@endpush
