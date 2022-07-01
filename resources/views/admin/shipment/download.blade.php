@extends('admin.layout.app')
@section('title','Delivery')
@section('content')
<div class="right_col" role="main">
    <div style="margin-top:1em">
		<div class="row">
			<div class="col-md-12">
				<div class="x_panel">
					<div class="row">
						<div class="col-md-5">
							<input  class="form-control" type="search" name="bulk_id" placeholder="search By Bulk ID" />
						</div>

						<div class="col-md-7 text-right">
							<a href="#" class="btn csv_file btn-sm btn-default" disabled onclick="get_csv()">Download CSV</a>
							<a href="#" onclick="get_pdf()" class="btn btn-sm pdf_file btn-default" disabled>Download PDF</a>
						</div>
						
					</div><br>
					<div class="row download-result"></div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script src="{{asset('vendors/select2/dist/js/select2.min.js')}}"></script>
<script>
	function get_shipment(bulk_id){
		$('.download-result').html('<p class="text-center text-warning">Loading...</p>');
		$.ajax({
			type: "get",url: '<?php echo '/admin/get-shipment-withBulkID/';?>'+bulk_id,
			success: function(data){
				$('.download-result').html(data);
				$('.csv_file').removeAttr('disabled');
            	$('.pdf_file').removeAttr('disabled');
			}
		});
	}
	function get_csv(){
		let bulk_id = $('[name=bulk_id]').val();
		if(bulk_id.length <1){
			alert('Set bulk ID first please!');return false;
		}
		window.open("/admin/get-shipment-files/csv/"+bulk_id,'Download CSV')
	}

	function get_pdf(){
		let bulk_id = $('[name=bulk_id]').val();
		if(bulk_id.length <1){
			alert('Set bulk ID first please!');return false;
		}
		window.open("/admin/get-shipment-files/pdf/"+bulk_id,'Download PDF')
	}

	$(function(){
		$('.select2').select2();
		// search with customer phone
		$('[name=bulk_id]').keypress(function(event){
		    var keycode = (event.keyCode ? event.keyCode : event.which);
		    if(keycode == '13'){
		        get_shipment( $(this).val() );
		    }
		});		
	});
</script>
@endpush