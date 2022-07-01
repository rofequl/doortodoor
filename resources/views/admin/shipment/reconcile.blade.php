@extends('admin.layout.app')
@section('title','Shipments Reconcile')
@section('content')
<div class="right_col" role="main" style="min-height: 674px;">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Reconcile Shipments </h3>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-6 col-sm-6">
        <div class="x_panel">
          <div class="x_content">
            <table class="table table-striped">
                <thead>
                <tr> <th>Customer info</th>
                    <th>Invoice ID</th><th class="text-right">Action</th>
                </tr>
                </thead>
                <tbody class="shipment-side"><tr>
                    <td colspan="3">Loading...</td>
                </tr></tbody>
            </table>

          </div>
        </div>
      </div>

      <div class="col-md-6 col-sm-6">
        <div class="x_panel">
          <div class="x_content">
            <table class="table table-striped">
              <thead>
                <tr> <th>Customer info</th>
                    <th>Invoice ID</th><th class="text-right">Action</th>
                </tr>
              </thead>
              <tbody class="reconcile-side"></tbody>
            </table>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(function(){
    $(".shipment-side").load('/admin/load-shipment-reconcilable');
    $(".reconcile-side").load('/admin/load-reconcile-shipments');
  })
</script>
@endpush