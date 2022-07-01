@extends('admin.layout.app')
@section('title','Merchant List')
@section('content')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Merchant List</h3>
                </div>
                <div class="title_right">
                    <div class="pull-right top_search">
                        <button type="button" class="btn btn-info btn-sm adNewParcel">  <i class="fa mdi mdi-cube-send"></i> Add new parcel
                        </button>
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">
                            <i class="fa fa-user-plus fs-13 m-r-3"></i> Create new Merchant
                        </button>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            @if ($errors->any())
                <ul class="alert alert-danger alert-dismissible">
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
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

                            <table id="datatable-buttons"
                                   class="table table-striped table-bordered dataTable no-footer dtr-inline">
                                <thead>
                                <tr class="bg-dark">
                                    <th>Merchant Id</th><th>Image</th>
                                    <th>Name</th> <th>Phone</th>
                                    <th>Email</th> <th>Status</th> <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user as $users)

                                    <tr>
                                        <th scope="row">{{$users['user_id']}}</th>
                                        <th scope="row"><img style="max-height:25px" class="img-thumbnail img-fluid" src="{{$users->image == null? asset('images/user.png'):asset('storage/user/'.$users->image)}}" ></th>
                                        <th scope="row">{{$users['first_name']}} {{$users['last_name']}}</th>
                                        <th scope="row">{{$users['phone']}}</th>
                                        <th scope="row">{{$users['email']}}</th>
                                        <th scope="row">
                                            @if($users->status==1)
                                                <span class="label label-success">Registerd</span> 
                                            @else
                                               <span class="label label-danger">Block</span>
                                            @endif
                                        </th>
                                        <th scope="row">
                                            <a href="/admin/merchant-details/{{$users->id}}" class="btn btn-primary btn-xs pull-right">View</a>
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
    </div>

    <!-- Modal for add merchant-->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2> <small>Merchant Information add</small> </h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br>
                            <form id="demo-form2" method="post" action="{{route('merchant.store')}}" autocomplete="off"
                                  class="form-horizontal form-label-left input_mask">  {{csrf_field()}}

                                <div class="col-xs-12 form-group has-feedback">
                                    <label for="shop_name">Shop Name:</label>
                                    <input type="text" class="form-control" placeholder="Example: Daraz"
                                         name="shop_name" id="shop_name" value="{{old('shop_name')}}">
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <label for="first_name">First Name:</label>
                                    <input type="text" class="form-control" placeholder="Arafat" name="first_name"
                                           id="first_name" value="{{old('first_name')}}">
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <label for="last_name">Last Name:</label>
                                    <input type="text" class="form-control" placeholder="Ahmed" name="last_name"
                                           id="last_name" value="{{old('last_name')}}">
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <label for="email">Email:</label>
                                    <input type="text" class="form-control" placeholder="abc@gmail.com" name="email"
                                           id="email" value="{{old('email')}}">
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <label for="phone">Phone:</label>
                                    <input type="text" class="form-control" placeholder="01234567898" name="phone"
                                           id="phone"
                                           value="{{old('phone')}}">
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <label for="password">Password:</label>
                                    <input type="password" class="form-control" placeholder="*******" name="password"
                                           id="password">
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <label for="password_confirmation ">Confirm Password:</label>
                                    <input type="password" class="form-control" placeholder="*******"
                                           name="password_confirmation"
                                           id="password_confirmation">
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <label for="address">Address:</label>
                                    <input type="text" class="form-control" placeholder="Mirpur, dhaka, bangladesh.."
                                           name="address"
                                           id="address"
                                           value="{{old('address')}}">
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <label for="website_link">Page / Website Link:</label>
                                    <input type="text" class="form-control" placeholder="http://www.xyz.com"
                                           name="website_link"
                                           id="website_link" value="{{old('website_link')}}">
                                </div>
                                <div class="col-md-12 form-group has-feedback ">
                                    <button type="submit" class="btn btn-success pull-right"><i
                                            class="mdi mdi-content-save m-r-3"></i>Save
                                    </button>
                                    <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">
                                        <i class="mdi mdi-cancel m-r-3"></i>Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Modal for add merchant-->
    <div id="addParcel" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="x_panel">
                        <div class="x_title"><h2> <small>Add new parcel</small> </h2><div class="clearfix"></div></div>
                        <div class="x_content">
                            <br>
                            <form id="demo-form2" method="post" class="form-horizontal form-label-left input_mask" action="/admin/add-parcelBy-admin">  {{csrf_field()}}
                                <div class="row my-4">
                                    <div class="col-md-12 text-left">
                                        <label for="Merchant">Merchant selection</label>
                                        <?php $users = \DB::table('users')->get();?>
                                        <select  class="form-control select2" style="width:100%;height:35px" name="user_id" required>
                                            <option value="" selected disabled>Select Merchant</option>
                                            @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="my-4" style="margin-top:1em ">
                                    @include('admin.shipment.includes.parcel-entry-form')
                                </div>

                                <div class="row"> <br>
                                    <label class="col-md-2">Status:</label>
                                    <div class="col-md-10">
                                        <label class="radio-inline"><input type="radio" value="0" name="status" checked>Label create (pickup)</label>
                                        <label class="radio-inline"><input type="radio" value="1" name="status" >Assigned to Rider</label>
                                        <label class="radio-inline"><input type="radio" value="2" name="status">Receipt by Rider</label> 
                                    </div>
                                </div>
                                <div class="row my-4">
                                    <div class="col-md-12 text-left driverArea" style="display: none">
                                        <label for="area">Rider selection</label>
                                        <?php $drivers = \DB::table('drivers')->get();?>
                                        <select  class="form-control select2" style="width:100%;height:35px" name="driver_id" required>
                                            <option value="" selected disabled>Select Rider</option>
                                            @foreach($drivers as $driver)
                                                    <option value="{{$driver->id}}">{{$driver->first_name}} {{$driver->last_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row my-4" style="margin-top:1em">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success pull-right"><i
                                                class="mdi mdi-content-check m-r-3"></i>Create Parcels
                                        </button>
                                        <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">
                                            <i class="mdi mdi-cancel m-r-3"></i>Cancel
                                        </button>
                                    </div>
                                </div>
                            </form>
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
    <script>
        $(function(){
            $('.adNewParcel').on('click',function(){
                $('#addParcel').modal('show');
            });

            $('[name=status]').on('change',function(){
                let status = $(this).val();
                if(status !='0'){
                    $('.driverArea').slideDown();
                    $('[name=driver_id]').prop('required',true)
                }else{
                    $('.driverArea').slideUp();
                    $('[name=driver_id]').prop('required',false)
                }
            })
        })
    </script>
@endpush
