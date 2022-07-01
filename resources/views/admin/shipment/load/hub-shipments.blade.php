<?php $areas = \DB::table('areas')->get(); ?>
@foreach($hubs as $key=>$hub)
<div class="row hub{{$hub->id}}" style="background:#f7f7f7;margin-bottom:1em">
	<div class="col-md-6">
    <p class="alert">Hub:
    @if($hub->status=='1' && $hub->zone->status=='1') {{$hub->zone->name}}  @else {{$hub->name}} @endif
	  <br>Parcel Records: <b class="num{{$hub->id}}">{{ user_hub_count($hub->id,$user_id,'on-dispatch') }}</b>
	  </p>
	</div>
	<div class="col-md-6 m-b-0 m-t-5">
	  <button class="btn btn-xs btn-info form-control s<?php echo $hub->id;?>" onclick="sorting(<?php echo $hub->id;?>)">Send to sorting</button>
    <button class="btn btn-xs btn-default form-control v" onclick="viewParcel(<?php echo $hub->id.','.$user_id;?>)" data-toggle="modal" data-target="#viewParcel">View Parcels</button>
    <a class="btn btn-xs btn-success form-control" href="/admin/user-hub-parcels-csv/<?php echo $hub->id.'/'.$user_id;?>" > <i class="fa fa-file-excel-o"></i> Get CSV</a>
	</div>
</div>
@endforeach

<!-- Modal to view hub base parcels -->
<div class="modal fade" id="viewParcel" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Parcel View</h4>
      </div>
      <div class="modal-body hub-parcels"></div>
    </div>
    
  </div>
</div>

 <script type="text/javascript">
 	function viewParcel(hub_id,user_id){
    $('.hub-shipments').css('min-height','500px')
 		$('.hub-parcels').html('Loading...');
    $.ajax({
       type: "get",url: '/admin/user-hub-parcels/'+hub_id+'/'+user_id,
       success: function(data){$('.hub-parcels').html(data);}
    });
 	}
</script>