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
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">
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
                                    <th>Distribution Zone</th>
                                    <th>Delivery Type</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($shipping as $shippings)

                                    <tr>
                                        <th scope="row">{{get_zone($shippings->zone_id)->name}}</th>
                                        <td>{{$shippings->delivery_type == 1? 'Regular':'Express'}}</td>
                                        <td>
                                            0 to {{$shippings->max_weight}} KG price {{$shippings->max_price}}
                                            Taka,<br>
                                            Next per {{$shippings->per_weight}} KG price {{$shippings->price}} Taka
                                        </td>
                                        <td>
                                            <a href=""
                                               style="margin: 0 2px" data-toggle="tooltip"
                                               data-placement="top" title=""
                                               data-original-title="Delete" class="delete"><i
                                                    class="fa fa-trash fa-2x"></i></a>
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

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>
                                <small>Shipping price add</small>
                            </h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br>
                            <form id="demo-form2" method="post"
                                  action="{{route('shippingPrice.add')}}" class="form-horizontal form-label-left">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="zone_id">Distribution
                                        Zone</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="col-md-7 col-xs-12 select2_single" name="zone_id"
                                                id="zone_id">
                                            <option></option>
                                            @foreach($zone as $zones)
                                                <option value="{{$zones->id}}">{{$zones->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group mt-2 text-right">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="cod"
                                                       id="cod_checkbox">
                                                <label class="form-check-label" for="cod_checkbox">
                                                    COD
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <div class="input-group" id="cod_checkbox_value" style="display: none">
                                            <input type="number" min="1" name="cod_value" class="form-control"
                                                   placeholder="Inter COD rate...">
                                            <span class="input-group-addon" id="priceLabel">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Delivery Type</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <div class="row">
                                            <div class="radio col-sm-6">
                                                <label class="">
                                                    <div class="iradio_flat-green" style="position: relative;"><input
                                                            type="radio" class="flat" checked=""
                                                            name="delivery_type" value="1"
                                                            style="position: absolute; opacity: 0;">
                                                        <ins class="iCheck-helper"
                                                             style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    Regular
                                                </label>
                                            </div>
                                            <div class="radio col-sm-6">
                                                <label class="">
                                                    <div class="iradio_flat-green" style="position: relative;"><input
                                                            type="radio" class="flat" name="delivery_type"
                                                            value="2"
                                                            style="position: absolute; opacity: 0;">
                                                        <ins class="iCheck-helper"
                                                             style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    Express
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <input type="number" class="form-control" value="0" readonly>
                                    <span class="input-group-addon" id="priceLabel">to</span>
                                    <input type="number" name="max_weight" placeholder="Insert KG"
                                           class="form-control">
                                    <span class="input-group-addon" id="priceLabel">kg price</span>
                                    <input type="number" name="max_price"
                                           class="form-control" placeholder="Insert Price">
                                </div>
                                <span class="help-block">Example: 0 to 1 kg price 60 taka</span>
                                <div class="input-group">
                                    <span class="input-group-addon" title="* Price" id="priceLabel">Next per</span>
                                    <input type="number" placeholder="Insert KG"
                                           name="per_weight" class="form-control">
                                    <span class="input-group-addon" id="priceLabel">kg price</span>
                                    <input type="number" name="price"
                                           class="form-control" placeholder="Insert Price">
                                </div>
                                <span class="help-block">Example: Next per 1 KG price 10 Taka</span>

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button class="btn btn-primary" data-dismiss="modal" type="button">Cancel
                                        </button>
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
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
        });
    </script>

@endpush
