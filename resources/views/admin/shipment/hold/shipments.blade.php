@extends('admin.layout.app')
@section('title',$type.' shipment List')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div><h3>{{$type}} Shipment List</h3></div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="table-responsive">
                                <table id="datatable-buttons"
                                    class="table table-striped table-bordered dataTable no-footer dtr-inline">
                                    <thead>
                                    <tr class="bg-dark"> <th>Hub</th><th>Parcels</th><th>Status</th> <th class="text-right">Action</th></tr>
                                    </thead>
                                    <tbody>
                                    @foreach($hubs as $key=>$hub)
                                        <tr>
                                            <td>{{$hub->name}}</td>
                                            @php
                                                $hubSHipmentBox_id = \DB::table('hub_shipment_boxes')->where('hub_id',$hub->id)->pluck('id')->first();
                                                echo $hubSHipmentBox_id;
                                                $boxVal = \DB::table('driver_hub_shipment_box')->where(['hub_shipment_box_id'=>$hubSHipmentBox_id,'status'=>$type]);
                                            @endphp
                                            <td>Parcel count: <b>{{$boxVal->count()}}</b></td>
                                            <td>
                                                <a href="#" disabled class="btn btn-xs btn-success"><i class="fa fa-check"> </i> @if($type=='partial') Partially delivered @else {{$type}} @endif </a> 
                                            </td>
                                            <td class="text-right">
                                                <a class="btn btn-info btn-xs" href="/admin/return-to-return-delivery/{{$hub->id}}/{{$type}}/{{$hubSHipmentBox_id}}">Return to Return-delivery</a></td>
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
    <link href="{{asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}">
    <style>
        #datatable-buttons_filter{display:none}
    </style>
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
