@extends('admin.layout.app')
@section('title','Shipments data')
@section('content')
  <div class="right_col" role="main">
    <div class="row">
      <div class="x_panel">
        <div class="page-title">
          <div class="title_left" style="width:20%"><h3>All Shipments </h3> </div>
          <div class="title_right text-right" style="width:80%;">
            @include('admin.shipment.load.shipment-filter')
          </div>
        </div>
        <div class="x_content">
          <div class="table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline">
                <thead>
                <tr class="bg-dark">
                  <th>Date</th>
                   <th>Customer info</th><th>Merchant</th> 
                    <th>Amount</th><th>Area</th><th>Trackings</th>
                    <th>Status</th><th class="text-right">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($shipments as $shipment)
                  <tr>
                    <td>{{date('M d, y',strtotime($shipment->created_at))}}</td>
                    <td>{{$shipment->name}} - {{$shipment->phone}}</td>
                    <td>{{$shipment->user->first_name.' '.$shipment->user->last_name}}</td>
                    <td>
                      @if($shipment->price==0)Pay by merchnat @else Pay by Customer @endif <b>({{$shipment->price}})</b>
                    </td>
                    <td> {{$shipment->area->name}} </td>
                    <td> <a target="_blank" href="/tracking?code={{$shipment->tracking_code}}">{{$shipment->tracking_code}} </a></td>
                    <td>@include('admin.shipment.status',['status'=>$shipment->status,'shipping_status'=>$shipment->shipping_status])</td>
                    <td class="text-right">
                      <button class="btn btn-xs btn-warning reset" id="{{$shipment->id}}">Reset</button>
                      <a href="/admin/shipment-details/{{$shipment->id}}" target="_blank" class="btn btn-xs btn-info">View</a>
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

 <div class="modal fade resetModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Reset shipment
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button> </h5>
        </div>
        <div class="modal-body">
            <form action="{{route('reset-shipment')}}" method="post">@csrf
              <div class="form-group row">
                <label class="col-form-label col-md-3 col-sm-3 text-right m-t-7">Reset Shipment as</label>
                <div class="col-md-5 col-sm-5">
                  <select name="label" class="form-control">
                    <option value="0">Label Create</option>
                    <option value="1">Pick-up (Admin end - assigned to rider)</option>
                    <option value="2">Pick-up (Rider end (Receive) - Rider has received)</option>
                    {{-- <option value="3">Dispatch Center</option>
                    <option value="4">In Transit</option>
                    <option value="5">Out for delivery</option> --}}
                  </select>
                </div>
                <div class="col-md-4 col-sm-4">
                  <button class="btn btn-info" type="submit"><i class="fa fa-undo"></i> Reset Shipment</button>
                </div>
              </div>   <input type="hidden" name="id">
            </form>
        </div>
    </div>
  </div>
</div>
@endsection
@push('style')
<style>
  select{
    padding:4.1px
  }
</style>
@endpush
@push('scripts')
<script>
  $(function(){
    $('[name=zone_id]').on('change',function(){
      let zone_id = $(this).val();
      $.ajax({
        type: "get", url: '/admin/zone-to-area/'+zone_id,
        success: function(data){
          $.each(data, function(key, value) {   
            $('#area') .append($("<option></option>")
              .attr("value", value.id).text(value.name)); 
          });
        }
      });
    });

    $('.reset').on('click',function(){
      let id = $(this).attr('id');
      $('[name=id]').val(id);
      $('.resetModal').modal('show');
    });
  })
</script>
@endpush