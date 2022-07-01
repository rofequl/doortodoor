@extends('admin.layout.app')
@section('title','Employee information')
@section('content')
    <div class="right_col" role="main">
        <div class="page-title">
            <div class="title_left">
                <h3>Admins dataTable</h3>
            </div>
            <div class="title_right">
                <div class="col-md-12 col-sm-12 form-group top_search">
                    <button data-toggle="modal" data-target=".add_employee" type="button" class="btn btn-info btn-sm pull-right">
                        <i class="fa fa-plus fs-13 m-r-3"></i> Add New Admin
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
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-striped table-bordered">
                                <thead>
                                <tr class="bg-dark">
                                    <th>Employee info</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade add_employee" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          	<div class="modal-header">
    	        <h5 class="modal-title" id="exampleModalLabel">New admin entry form
    	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    	          <span aria-hidden="true">&times;</span>
    	        </button> </h5>
    	    </div>
    	    <div class="modal-body">
    	    	<form id="employee_form" method="post" enctype="multipart/form-data" action>@csrf
    	    		@include('admin.admins.form') <br>
    	    		<span class="form_result"></span>
    	    		<button class="btn btn-info" type="submit"><i class="fa fa-check"></i> Save Admin</button>
    	    	</form>
    	    </div>
        </div>
      </div>
    </div>

    <div class="modal fade edit_employee" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Admin information
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button> </h5>
            </div>
            <div class="modal-body">
                <form action="{{route('update-admin')}}" id="edit_employee" method="post" enctype="multipart/form-data">@csrf
                    @include('admin.admins.form') <br>
                    <span class="form_result2"></span>
                    <input type="hidden" name="id">
                    <input type="hidden" name="oldLogo">
                    <button class="btn btn-info" type="submit"><i class="fa fa-edit"></i> Update Admin</button>
                </form>
            </div>
        </div>
      </div>
    </div>

@endsection
@push('style')
    <style type="text/css">.table-responsive{min-height:400px }</style>
    <link href="{{asset('vendors/sweetalert/sweetalert.css')}}" rel="stylesheet"/>
    <!-- Datatables -->
    <link href="{{asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}"
          rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}"
          rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
   
    <link rel="stylesheet" href="{{asset('vendors/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/select2/dist/css/bootstrap4-select2.css')}}">
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

    <script src="{{asset('vendors/select2/dist/js/select2.min.js')}}"></script>
 
    <script>
        $('select:not(.normal)').each(function () { $(this).select2({ dropdownParent: $(this).parent() });});
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      
        $(document).ready(function () {
        	//add
            $('#employee_form').on('submit', function(event){
				event.preventDefault(); 
			   	$("[type='submit']").html('<i class="fa fa-spinner fa-pulse fa-spin fa-fw"></i><span class="sr-only"></span> Loading...');
			    $("[type='submit']").prop('disabled',true);

			   	$.ajax({
			    	url:"{{ route('save-admin') }}",
			    	method:"post",
			    	data: new FormData(this),
			   		contentType: false,cache:false, processData: false,
			    	dataType:"json",
			    	success:function(data){
				     	var html = '';
				     	if(data.errors) {
					        html = '<div class="alert alert-danger">';
					        for(var count = 0; count < data.errors.length; count++)
					        { html += '<p>' + data.errors[count] + '</p>';break;}
					        html += '</div>';
				     	}
				     	if(data.success){
					        html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('.add_employee').modal('hide');
					        $('#employee_form')[0].reset();
					        $('#dataTable').DataTable().ajax.reload();
				     	}
				     	$("[type='submit']").html('<i class="fa fa-check"></i> Save admin');
			    		$("[type='submit']").prop('disabled',false);
				     	$('.form_result').html(html);
                        
				    }
			   	});
			});

            // get data
            $(function () { table.ajax.reload(); });
            let table = $('.table').DataTable({
                processing: true,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only"></span>'
                },
                serverSide: true,ajax: "{{route('admins')}}",
                order: [ [0, 'desc'] ],
                columns: [
                    {data: 'employee_info'},
                    {data: 'email'},
                    {data: 'address'},
                    {data: 'action', orderable: false, searchable: false, class:'text-right'}
                ]
            });

            // show edit data
            $('#dataTable').on('click', '.edit' ,function(e){
                let id = $(this).attr('id')
                $('.edit_employee').modal('show');
                $('[type=password]').remove();
                $.ajax({
                    url: "{{ route('show-admin') }}",
                    type: 'get', data: {id: id}, dataType: 'json',
                    success: function (data) {
                        $('[name=id]').val(data.id);
                        $('[name=first_name]').val(data.first_name).trigger('change');
                        $('[name=last_name]').val(data.last_name).trigger('change');
                        $('[name=phone]').val(data.phone).trigger('change');
                        $('[name=address]').val(data.address).trigger('change');
                        $('[name=email]').val(data.email).trigger('change');
                        $('[name=oldLogo]').val(data.image).trigger('change');
                    }
                });

                $.get( "/admin/get-admin-hub-ids/"+id, function( data ) {
                    var selectedValues = data.split(',');
                    $(".select2").val(selectedValues).trigger('change');
                });
                

            });

            $('#edit_employee').on('submit', function(event){
                event.preventDefault(); 
                $("[type='submit']").html('<i class="fa fa-spinner fa-pulse fa-spin fa-fw"></i><span class="sr-only"></span> Loading...');
                $("[type='submit']").prop('disabled',true);

                $.ajax({
                    url:"{{ route('update-admin') }}",
                    method:"post",
                    data: new FormData(this),
                    contentType: false,cache:false, processData: false,
                    dataType:"json",
                    success:function(data){
                        var html = '';
                        if(data.errors) {
                            html = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.errors.length; count++)
                            { html += '<p>' + data.errors[count] + '</p>';break;}
                            html += '</div>';
                        }
                        if(data.success){
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#employee_form')[0].reset();
                            $('#dataTable').DataTable().ajax.reload();
                        }
                        $("[type='submit']").html('<i class="fa fa-check"></i> Save employee');
                        $("[type='submit']").prop('disabled',false);
                        $('.form_result2').html(html);
                        $('.edit_employee').modal('hide');
                    }
                });
            });

            // delete data
            $('#dataTable').on('click', '.delete' ,function(e){
               if(confirm('Are you sure to remove the admin record??')){
                let id = $(this).attr('id')
                $.ajax({
                   url:"/admin/admin/delete/"+id+"",
                   dataType:"json",
                   success:function(){
                        $('#dataTable').DataTable().ajax.reload();
                   }
                });
               }
            });
        });

    </script>

@endpush
