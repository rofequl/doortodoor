@extends('admin.layout.app')
@section('title','Dispatch shipment with bulk id')
@section('content')
<div class="right_col" role="main">
    <div style="margin-top:1em">
		<div class="row">
            <div class="x_panel">
				<div class="col-md-6 left-side"></div>
				<div class="col-md-6">
					<input type="text" id="invoice_id" placeholder="Invoice ID"><br><br>
					<div class="right-side"></div>
				</div>
            </div>
		</div>
	</div>
</div>
@endsection


@push('scripts')
<script type="text/javascript">
 	$('#invoice_id').keypress(function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			$(".right-side").html('Working.....');
			$('#invoice_id').prop('disabled', true);
			let invoice_id = $(this).val();
			$.ajax({
			type: "get",url: '/admin/thirdparty-rightWithInvoice/'+invoice_id,
			success: function(data){
				$(".left-side").load('/admin/thirdparty-left/<?php echo $hub->id;?>');
				$(".right-side").load('/admin/thirdparty-right/<?php echo $hub->id;?>');
				$('#invoice_id').prop('disabled', false);
				$('#invoice_id').val('');
			}
			});
		}
	});		

	$(".left-side").load('/admin/thirdparty-left/<?php echo $hub->id;?>');
	$(".right-side").load('/admin/thirdparty-right/<?php echo $hub->id;?>');
</script>
@endpush