@extends('admin.layout.app')
@section('title','slider information')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left"> <h3>Messages from contact page </h3></div>
            </div>
            <div class="clearfix"></div>
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                   <i class="fa fa-check"></i> {{ session()->get('message') }}
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                  <div class="x_panel">
                    <div class="">
                      <table id="dataTable" class="table table-striped table-bordered">
                          <thead>
                          <tr class="bg-dark">
                              <th>Sender name</th><th>email</th>
                              <th>Message</th><th>Action</th>
                          </tr>
                          </thead>
                      </table>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>


<div class="modal fade viewMore" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Message View
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button> </h5>
        </div>
        <div class="modal-body result"></div>
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

  <script>
    // get data
    $(function () { table.ajax.reload(); });
      let table = $('.table').DataTable({
      processing: true,
      "language": { processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>' },
      serverSide: true,ajax: "{{route('messages')}}",
      order: [ [0, 'desc'] ],
      columns: [
          {data: 'sender'},{data: 'email'}, {data: 'message'},
          {data: 'action', orderable: false, searchable: false, class:'text-right'}
      ]
    });

    // show data
    $('#dataTable').on('click', '.show' ,function(e){
        let id = $(this).attr('id');
        $('.viewMore').modal('show');
        $('.result').html('Loading....');
        $.ajax({
          url: "/admin/message-show/"+id,
          type: 'get', data: {id: id},
          success: function (data) {$('.result').html(data);}
        });
    });

    // delete data
    $('#dataTable').on('click', '.delete' ,function(e){
       if(confirm('Are you sure to remove the record??')){
        let id = $(this).attr('id')
        $.ajax({
           url:"/admin/delete-message/"+id+"",
           success:function(data){
            if(data.success){ $('#dataTable').DataTable().ajax.reload();}
           }
        });
       }
    });
  </script>

@endpush
