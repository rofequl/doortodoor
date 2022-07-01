

@extends('admin.layout.app')
@section('title','slider information')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left"> <h3>About us page setup</h3></div>
                <div class="title_right">
                    <div class="col-md-12 col-sm-12 form-group top_search">
                        <button data-toggle="modal" data-target=".add_slider" type="button" class="btn btn-info btn-sm pull-right">
                            <i class="fa fa-plus fs-13 m-r-3"></i> Add New post
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
                   <i class="fa fa-check"></i> {{ session()->get('message') }}
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="x_panel">

                      <p class="alert text-left alert-info"> About us page basic data-form with extra contents
                        <button class="btn btn-primary pull-right" type="button" data-toggle="collapse" data-target="#data1" aria-expanded="false" aria-controls="data1">
                          Get basic data
                        </button>
                      </p>
                    
                      <form id="data1" action="{{route('save-about-1')}}" method="post" class="x_content collapse @if(session()->has('message'))in @endif" enctype="multipart/form-data">@csrf
                      
                         <textarea id="description" name="description" class="form-control description">{!! old('description')??$about->description !!}</textarea> <br><br>

                         @if($about->id==null)
                          <button class="btn btn-info pull-right" name="submit" value="save" type="submit">Setup about us page</button>
                          @else <button class="btn btn-info pull-right" name="submit" value="update" type="submit">Update about us page</button> @endif
                        </form>
                    </div>
                </div>

                <div class="col-12">
                  <div class="x_panel">
                    <div class="">
                      <table id="dataTable" class="table table-striped table-bordered">
                          <thead>
                          <tr class="bg-dark">
                              <th>Post title</th><th>Description</th>
                              <th class="text-right">Status</th>
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



<div class="modal fade add_slider" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create new post for <b>about us</b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button> </h5>
      </div>
      <div class="modal-body">
        <form id="slider_form" method="post" enctype="multipart/form-data">@csrf
          @include('admin.website_manage.about.form') <br>
          <span class="form_result"></span>
          <button class="btn btn-info pull-right" type="submit"><i class="fa fa-check"></i> Save Post</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade edit_post" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit About post
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button> </h5>
        </div>
        <div class="modal-body">
            <form id="edit_post" method="post" enctype="multipart/form-data">@csrf
                @include('admin.website_manage.about.form')<br><br>
                <span class="form_result2"></span>
                <input type="hidden" name="id">
                <button class="btn btn-info pull-right" type="submit"><i class="fa fa-edit"></i> Update post</button>
            </form>
        </div>
    </div>
  </div>
</div>

@endsection
@push('style')

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
  
  <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
  <script>
    CKEDITOR.replace('description',{
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
      filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
    });

    $('#slider_form').on('submit', function(event){
        event.preventDefault(); 
        $('.modal-body').css('opacity','0.4');
          $("[type='submit']").html('<i class="fa fa-spinner fa-pulse fa-spin fa-fw"></i><span class="sr-only"></span> Loading...');
          $("[type='submit']").prop('disabled',true);

          $.ajax({
            url:"{{ route('save-about-us') }}",
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
              $("[type='submit']").html('<i class="fa fa-check"></i> Save About-us');
              $("[type='submit']").prop('disabled',false);
              $('.modal-body').css('opacity','1.0');
              $('.form_result').html(html);  
            }
          });
    });

    // get data
    $(function () { table.ajax.reload(); });

      let table = $('.table').DataTable(
        {
          processing: true,
          "language": { processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>' },
          serverSide: true,ajax: "{{route('about-posts')}}",
          order: [ [0, 'desc'] ],
          columns: [
              {data: 'title'},{data: 'description'}, {data: 'status'},
              {data: 'action', orderable: false, searchable: false, class:'text-right'}
          ]
      }
    )

    // show edit data
    $('#dataTable').on('click', '.edit' ,function(e){
        let id = $(this).attr('id');
        $('.edit_post').modal('show');
        $('[type=password]').remove();
        $.ajax({
            url: "/admin/about-show/"+id,
            type: 'get', data: {id: id}, dataType: 'json',
            success: function (data) {
                $('[name=id]').val(data.id);
                $('[name=title]').val(data.title).trigger('change');
                $('[name=description]').val(data.description).trigger('change');
                $('[name=status]').val(data.status).trigger('change');
            }
        });
    });

    $('#edit_post').on('submit', function(event){
        event.preventDefault(); 
        $('.modal-body').css('opacity','0.4');
        $("[type='submit']").html('<i class="fa fa-spinner fa-pulse fa-spin fa-fw"></i><span class="sr-only"></span> Loading...');
        $("[type='submit']").prop('disabled',true);

        $.ajax({
            url:"{{ route('update-about-post') }}",
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
                    $('.edit_post').modal('hide');
                    $('#dataTable').DataTable().ajax.reload();
                }
                $("[type='submit']").html('<i class="fa fa-edit"></i> Update Post');
                $("[type='submit']").prop('disabled',false);
                $('.modal-body').css('opacity','1.0');
                $('.form_result2').html(html);
            }
        });
    });

    // delete data
    $('#dataTable').on('click', '.delete' ,function(e){
       if(confirm('Are you sure to remove the admin record??')){
        let id = $(this).attr('id')
        $.ajax({
           url:"/admin/delete-about-post/"+id+"", dataType:"json",
           success:function(data){
            if(data.success){ $('#dataTable').DataTable().ajax.reload();}
           }
        });
       }
    });
  </script>

@endpush

