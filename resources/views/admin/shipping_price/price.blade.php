@extends('admin.layout.app')
@section('title','Shipping price manage')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Shipping Price Manage</h3>
                </div>

                <div class="title_right">
                    <div class="col-md-6 form-group pull-right top_search">
                        <button type="button" class="btn pull-right btn-info btn-sm" data-toggle="modal" data-target="#myModal">
                            Add New shipping price
                        </button>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{$error}}
                    </div>
                @endforeach
            @endif
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

                            <table id="datatable-responsive"
                                   class="table table-striped table-bordered dataTable no-footer dtr-inline">
                                <thead>
                                <tr class="bg-dark">
                                    <th>Distribution Zone</th> <th>Delivery Type</th>
                                    <th>COD </th> <th>Price</th> <th class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($shipping as $key=>$shippings)
                                    <tr>
                                        <th scope="row">{{get_zone($shippings->zone_id)->name}}</th>
                                        <td>{{$shippings->delivery_type == 1? 'Regular':'Express'}}</td>
                                        <td class="">
                                            @if($shippings->cod_value !=null) {{$shippings->cod_value}} % @else not set @endif
                                        </td>
                                        <td>
                                            0 to {{$shippings->max_weight}} KG price {{$shippings->max_price}}
                                            Taka,<br>
                                            Next per {{$shippings->per_weight}} KG price {{$shippings->price}} Taka
                                        </td>
                                        
                                        <td class="text-right">
                                            <a href="/admin/delete-shipping-price/{{$shippings->id}}" data-toggle="tooltip"
                                               data-placement="top" data-original-title="Delete" class="delete" onclick="return confirm('Are you sure to remove the price permanently??')"><i class="fa text-danger fa-trash fa-2x"></i></a>
                                            
                                            <a href="#" class="show-price" data-id="{{$shippings->id}}" data-toggle="modal" data-target="#editModal"><i class="fa text-info fa-edit fa-2x"></i></a>
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

<!-- Modal to add price -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="demo-form2" method="post" class="form-horizontal form-label-left"> @csrf
                <div class="modal-body">
                    <div class="x_panel">
                        <div class="x_title"><h2><small>Shipping price add</small></h2><div class="clearfix"></div></div>
                        <div class="x_content">
                            @include('admin.shipping_price.form')
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal to edit price -->
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="demo-form2" method="post" action="{{route('shippingPrice.edit')}}" class="form-horizontal form-label-left"> @csrf
                <div class="modal-body">
                    <div class="x_panel">
                        <div class="x_title"><h2><small>Shipping price Edit</small></h2><div class="clearfix"></div></div>
                        <div class="x_content">
                            @include('admin.shipping_price.form')
                            <input type="hidden" name="id">
                        </div>
                    </div>
                </div>
            </form>
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
        $(document).ready(function () {
            $("#cod_checkbox").change(function () {
                if (this.checked) {
                    $('#cod_checkbox_value').show();
                } else {
                    $('#cod_checkbox_value').hide();
                }
            });

            // shiw price 
            $('.show-price').on('click',function(){
                let id = $(this).data('id');
                $.get( "/admin/show-shipping-price/"+id, function( data ) {
                    $('[name=cod_value]').val(data.cod_value);
                    $('.cod_checkbox_value').show();
                    if(data.cod_value==null){
                        $('[type=checkbox]').prop('checked', false);
                    }else{  $('[type=checkbox]').prop('checked', true); }
                    $('[name=id]').val(id);
                    $('[name=per_weight]').val(data.per_weight);
                    $('[name=max_weight]').val(data.max_weight);
                    $('[name=max_price]').val(data.max_price);
                    $('[name=price]').val(data.price);
                    $(".select2_single").val(data.zone_id).trigger('change');
                    // $('[name=delivery_type]['+ data.delivery_type+']').prop('checked', true);
                    $('input[name=delivery_type][value='+data.delivery_type+']').prop('checked', 'checked');
                });
            });
        });
    </script>

@endpush
