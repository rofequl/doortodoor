@extends('admin.layout.app')
@section('title','Merchant List')
@section('content')
    <div class="right_col" role="main">
        <div style="margin-top:1em">
            <div class="row">
                <div class="panel panel-primary">
                  <div class="panel-heading">marchant information</div>
                  <div class="panel-body">
                    <div class="col-md-2">
                        <img src="{{$user->image == null? asset('images/user.png'):asset('storage/user/'.$user->image)}}" style="max-width:100%;max-height:160px" class="img-rounded" alt="{{$user->first_name}}">
                    </div>
                    <div class="col-md-10 text-capitalize">
                       <b>Name:</b> {{$user->first_name}} {{$user->last_name}}<hr/>
                        <b>Phone:</b> {{$user->phone}} &nbsp; &nbsp; &nbsp; 
                        <b>Email:</b> {{$user->email}}<hr>
                        <b>Address:</b> {{$user->address}}
                    </div>
                  </div>
                </div>
                <div class="page-title">
                    <h3>Merchant cencelled Shipment List
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
                                <th>#SL</th><th>Image</th>  <th>Info</th>
                                <th>Contact</th> <th>Status</th> <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($shipments as $key=>$shipment)
                                <tr>
                                    <th scope="row"> {{$key+1}}</th>

                                    <th scope="row">
                                        <img width="42" height="42" class="img-thumbnail img-fluid" src="{{$shipment->image == null? asset('images/user.png'):asset('storage/user/'.$shipment->image)}}">
                                    </th>

                                    <th scope="row">Name: {{$shipment->name}} <br>Price: {{$shipment->price}}
                                    </th>
                                    <th scope="row"><i class="fa fa-phone"></i> {{$shipment->phone}}<br>

                                    <i class="fa fa-map-marker"></i> {{$shipment->address}}<br>
                                    </th>
                                    <th scope="row">
                                        @include('admin.shipment.status',
                                        ['status'=>$shipment->status,'shipping_status'=>$shipment->shipping_status])
                                    </th>
                                    <th scope="row">
                                        <a href="/admin/back-to-shipment/{{$shipment->id}}" class="btn btn-primary btn-xs">back To Shipment <i class="fa fa-undo"></i></a>
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
