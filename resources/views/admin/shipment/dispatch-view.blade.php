@extends('admin.layout.app')
@section('title','Dispatch shipment with bulk id')
@section('content')
<div class="right_col" role="main">
    <div style="margin-top:1em">
		<div class="row">
			<div class="col-md-6">
				<div class="x_panel status-dispatch">
					<p class="alert text-center">Loading...</p>
				</div>
			</div>

			<div class="col-md-6">
				<div class="x_panel status-on-transit">
					<p class="alert text-center">Loading...</p>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

<!-- Modal to view hub base parcels -->
<div class="modal" id="myModal2">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Parcels view
          <button data-dismiss="modal" type="button" class="close">×</button></h4>
        </div><div class="container hub-parcles"></div>
        <div class="modal-body"></div>
        <div class="modal-footer" style="margin-top:-2em;">
          <a href="#" class="btn" data-dismiss="modal">Close</a>
        </div>
      </div>
    </div>
</div>


@push('scripts')
<script type="text/javascript">
 	$(".status-dispatch").load('/admin/status-dispatch/<?php echo $hub->id;?>');
 	$(".status-on-transit").load('/admin/status-on-transit/<?php echo $hub->id;?>');
 	function dispatch_shipments(box_id){
 		$('.hub-parcles').html('Loading...');$('#myModal2').modal('show');
	    $.ajax({
	       type: "get",url: '/admin/dispatch-box-view/'+box_id,
	       success: function(data){$('.hub-parcles').html(data);}
	    });
 	}

 	function changeBoxStatus(box_id){
 		$('.mts'+box_id).html('Progress...');
 		$('.mts'+box_id).prop('disabled',true);
 		$.ajax({
	       	type: "get",url: '/admin/change-box-status/'+box_id+'/on-transit',
	       	success: function(data){
	       		$(".status-dispatch").load('/admin/status-dispatch/<?php echo $hub->id;?>');
 				$(".status-on-transit").load('/admin/status-on-transit/<?php echo $hub->id;?>');
	       	},error: function(xhr, status, error) {
			  alert(xhr.responseText);
			}
	    });
 	}
</script>
@endpush