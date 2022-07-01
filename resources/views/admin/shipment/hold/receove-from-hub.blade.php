@extends('admin.layout.app')
@section('title','Return - Receive form hub')
@section('content')
<div class="right_col" role="main">
    <div class="row">
        <div class="x_panel">
            <div class="x_content">
                <table class="table table-striped table-bordered dataTable no-footer dtr-inline" id="datatable-buttons">
                    <thead>
                        <tr class="bg-dark">
                            <th>Customer info</th>
                            <th>Parcel info</th>
                            <th>Merchant</th>
                            <th>Amount</th>
                        </tr>     
                    </thead>  
                    <tbody>   
                        @foreach($boxes as $key=>$box)
                            @foreach(explode(',',$box->shipment_ids) as $shipment_id)
                            <?php $shipment = \App\Shipment::where('id',$shipment_id)->first(); ?>
                                <tr>
                                    <td>Name: {{$shipment->name}} <br>
                                        Phone: {{$shipment->phone}} <br>
                                        Address: {{$shipment->address}} 
                                    </td>
                                    <td>Invoice ID: {{$shipment->invoice_id}} <br>
                                        Area: {{$shipment->area->name}} (Hub: {{hub_from_area($shipment->area_id)->name}})<br>
                                        Weight: {{$shipment->weight}} KG <br>
                                        Delivery type: @if($shipment->delivery_type=='1') Regular @else Express @endif delivery
                                    </td>
                                    <td>{{$shipment->user->first_name}} {{$shipment->user->last_name}}</td>
                                    <td> @if($shipment->price==0) Pay by merchant @else Pay by customer @endif 
                                        ({{$shipment->price}}) <br>
                                        Status: {{$box->status}}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
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
@endpush

