@extends('driver.layout.app')
@section('title','Merchant List')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left"><h3>Merchant Shipment List
                </h3></div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <div class="x_panel">
                        <div class="x_content table-responsive">

                            <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline">
                                <thead>
                                <tr class="bg-dark">
                                    <th>Merchant Id</th> <th>Image</th><th>Info</th> 
                                    <th>Contact</th><th>Shipment</th><th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user as $users)
                                    @if(driver_shipments( Auth::guard('driver')->user()->id, $users->id) >0)
                                    <tr>
                                        <th scope="row"> {{$users->user_id}}</th>
                                        <th scope="row"><img width="42" height="42" class="img-thumbnail img-fluid" src="{{$users->image == null? asset('images/user.png'):asset('storage/user/'.$users->image)}}"></th>
                                        <th scope="row">Name: {{$users['first_name']}} {{$users['last_name']}}<br>
                                            Shop Name: {{$users->shop_name}}
                                        </th>
                                        <th scope="row"><i class="fa fa-phone"></i> {{$users['phone']}}<br>
                                            <i class="fa fa-envelope-o"></i> {{$users['email']}}<br>
                                            <i class="fa fa-map-marker"></i> {{$users['address']}}<br>
                                        </th>
                                        <th scope="row">
                                            <button class="btn btn-info">
                                              {{driver_shipments( Auth::guard('driver')->user()->id, $users->id) }} parcel
                                            </button>  
                                                
                                        </th>
                                        <th class="text-right">
                                            <?php 
                                            if(driver_shipments( Auth::guard('driver')->user()->id, $users->id) > 0) {
                                                $ability = '';
                                                $action =' /driver/shipping-details/'.$users->id.'/pending';
                                            }else{
                                                $ability = 'disabled'; $action = 'javaScript:void(0)';
                                            }?>

                                            <a href="{{$action}}" class="btn btn-primary" {{$ability}}>View</a> 
                                        </th>
                                    </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>

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
