@extends('driver.layout.app')
@section('title','My '.$type.' parcels')
@section('content')

<div class="right_col" role="main">
    <div style="margin-top:1em">
        <div class="row">
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
