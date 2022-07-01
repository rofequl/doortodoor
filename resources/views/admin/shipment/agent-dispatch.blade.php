@extends('admin.layout.app')
@section('title','Agent dispatch center')
@section('content')
  <div class="right_col" role="main">
    <div class="row">
      <div class="col-md-12">  <h3>Agent dispatch center </h3></div>

      <div class="col-md-6 ">
        <div class="x_panel row agent-side">Loading....</div>
      </div>

      <div class="col-md-6 ">
        <div class="row x_panel">
          <input type="search" id="invoiceID" placeholder="Invoice ID" class="form-control">
        </div>
        <div class="x_panel row driver-side">Loading...</div>
      </div>
    </div>

  </div>
@endsection


@push('style')
  <style type="text/css">
      .table {margin-bottom: 10px; border:2px solid; font-size: 13px}
      .select{padding:2px;}
      .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
          padding: 2px; line-height: 1.42857143;
          vertical-align: middle;border-top: 1px solid #ddd;
      }
    input[type='number']{padding:2px}
  </style>
  <link href="{{asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}"
        rel="stylesheet">
  <link href="{{asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}"
        rel="stylesheet">
  <link href="{{asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
@endpush
@push('scripts')
  <script>
    $(function(){
      $('#invoiceID').keypress(function (e) {
        if (e.which == '13') {
          $('#invoiceID').prop('disabled',true);
          let invoiceID = $(this).val();
          // alert(invoiceID);return false;
          $.ajax({
            type: "get",url: '/admin/agentDispatch-to-driverAssign-withInvoice/'+invoiceID,
            success: function(data){
              $(".agent-side").load('/admin/agent-dispatch-agentSide');
              $(".driver-side").load('/admin/agent-dispatch-driverSide');
              $('#invoiceID').prop('disabled',false);
              $('#invoiceID').val('');
            },error: function (request, error) {
              $('.hub'+hub_id).html('<p class="alert text-danger"><i class="fa fa-times-circle"></i> Execution failed! Please try again!!</p>');
            },
          });
        }
      });
      
      $(".agent-side").load('/admin/agent-dispatch-agentSide');
      $(".driver-side").load('/admin/agent-dispatch-driverSide');
    })
</script>
@endpush

