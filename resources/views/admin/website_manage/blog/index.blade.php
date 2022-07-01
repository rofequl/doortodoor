@extends('admin.layout.app')
@section('title','blog posts')
@section('content')
    <div class="right_col" role="main">
        <div class="">

            <div class="page-title">
                <div class="title_left">
                    <h3>blog-posts dataTable</h3>
                </div>
                <div class="title_right">
                    <div class="col-md-12 col-sm-12 form-group top_search">
                        <button data-toggle="modal" data-target=".add_slider" type="button" class="btn btn-info btn-sm pull-right">
                            <i class="fa fa-plus fs-13 m-r-3"></i> Add Blog
                        </button>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
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
                                        <th>Image</th>
                                        <th>Post title</th>
                                        <th>Category</th>
                                        <th>Status</th>
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
    </div>



<div class="modal fade add_slider" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      	<div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Create blog post
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button> </h5>
	    </div>
	    <div class="modal-body">
	    	<form id="slider_form" action="{{ route('save-blog') }}" method="post" enctype="multipart/form-data">@csrf
	    		@include('admin.website_manage.blog.form') <br>
	    		<span class="form_result"></span>
	    		<button class="btn btn-info pull-right" type="submit"><i class="fa fa-check"></i> Save blog post</button>
	    	</form>
	    </div>
    </div>
  </div>
</div>

<div class="modal fade edit_slider" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit post
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button> </h5>
        </div>
        <div class="modal-body">
            <form action="{{route('update-blog')}}" id="edit_slider" method="post" enctype="multipart/form-data">@csrf
              	@include('admin.website_manage.blog.form')<br><br>
                <span class="form_result2"></span>
                <input type="hidden" name="id">
                <input type="hidden" name="oldLogo">
                <button class="btn btn-info pull-right" type="submit"><i class="fa fa-edit"></i> Update blog</button>
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
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      
        $(document).ready(function () {
        	$('.top_search').on('click',function(){
        		$('#slider_form')[0].reset();
                $('.photo').attr("src", '').trigger('change');
        	})

        	//add
            $('#slider_form').on('submit', function(event){
				event.preventDefault(); 
				$('.modal-body').css('opacity','0.4');
			   	$("[type='submit']").html('<i class="fa fa-spinner fa-pulse fa-spin fa-fw"></i><span class="sr-only"></span> Loading...');
			    $("[type='submit']").prop('disabled',true);

			   	$.ajax({
			    	url:"{{ route('save-blog') }}",
			    	method:"post",data: new FormData(this),
			   		contentType: false,cache:false, processData: false,
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
                            $('.add_slider').modal('hide');
					        $('#slider_form')[0].reset();
					        $('#dataTable').DataTable().ajax.reload();
				     	}
				     	$("[type='submit']").html('<i class="fa fa-check"></i> Save Blog');
			    		$("[type='submit']").prop('disabled',false);
				     	$('.modal-body').css('opacity','1.0');
				    }
			   	});
			});

            // get data
            $(function () { table.ajax.reload(); });
                let table = $('.table').DataTable({
                processing: true,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                },
                serverSide: true,ajax: "{{route('blogs')}}",
                order: [ [0, 'desc'] ],
                columns: [
                    {data: 'photo'},{data: 'title'}, {data: 'category'},{data: 'status'},
                    {data: 'action', orderable: false, searchable: false, class:'text-right'}
                ]
            });

            // show edit data
            $('#dataTable').on('click', '.edit' ,function(e){
                let id = $(this).attr('id');
                $.ajax({
                    url: "/admin/show-blog/"+id,
                    type: 'get', data: {id: id}, dataType: 'json',
                    success: function (data) {
                        $('.edit_slider').modal('show');
                        $('[name=id]').val(data.id);
                        $('[name=title]').val(data.title).trigger('change');
					    $('.photo').attr("src", '/'+data.photo).trigger('change');
                        $('[name=oldLogo]').val(data.photo).trigger('change');
                        $('[name=blog_category_id]').val(data.blog_category_id).trigger('change');
                        $('[name=description]').val(data.description).trigger('change');
                        $('[name=status]').val(data.status).trigger('change');
                    }
                });
            });

            $('#edit_slider').on('submit', function(event){
                event.preventDefault(); 
                $('.modal-body').css('opacity','0.4');
                $("[type='submit']").html('<i class="fa fa-spinner fa-pulse fa-spin fa-fw"></i><span class="sr-only"></span> Loading...');
                $("[type='submit']").prop('disabled',true);

                $.ajax({
                    url:"{{ route('update-blog') }}",
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
                            $('#slider_form')[0].reset();
                            $('.edit_slider').modal('hide');
                            $('#dataTable').DataTable().ajax.reload();
                        }
                        $("[type='submit']").html('<i class="fa fa-edit"></i> Update blog');
                        $("[type='submit']").prop('disabled',false);
                        $('.modal-body').css('opacity','1.0');
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
                   url:"/admin/blog/delete/"+id+"",
                   dataType:"json",
                   success:function(){ $('#dataTable').DataTable().ajax.reload(); }
                });
               }
            });
        });

    </script>

@endpush
