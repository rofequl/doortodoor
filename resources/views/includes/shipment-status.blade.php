
@if($status==1)
@if($shipping_status=='0')
    <span class="label label-success">Label Create</span>
@elseif($shipping_status=='1')
    <span class="label label-info">Pick-up</span>

@elseif($shipping_status=='2')
    <span class="label label-primary">Pic-up</span>

@elseif($shipping_status=='3')
    <span class="label label-primary"> Dispatch Center</span>

@elseif($shipping_status=='4')
    <span class="label label-primary">In Transit</span>

@elseif($shipping_status=='5')
    <span class="label label-primary">Out for delivery</span>

@elseif($shipping_status >=6)
    @if($shipping_status=='6')
        <i class="fa fa-check-square-o fa-3x text-success"></i> <br>
        <span class="text-success">Delivered</span>
    @elseif($shipping_status=='on-6')
         <i class="fa fa-check-square-o fa-3x text-success"></i> <br>
        <span class="text-success">Delivered (init)</span>
    
    @elseif($shipping_status=='6.5')
         <i class="fa fa-check-square-o fa-3x text-success"></i> <br>
        <span class="text-success">Partial delivery</span>
    @elseif($shipping_status=='on-6.5')
        <i class="fa fa-check-square-o fa-3x text-success"></i> <br>
        <span class="text-success">Partial delivery (init)</span>

    @elseif($shipping_status=='7')
        <i class="fa fa-check-square-o fa-3x text-warning"></i> <br>
        <span class="text-warning">Hold</span>
    @elseif($shipping_status=='on-7')
        <i class="fa fa-check-square-o fa-3x text-warning"></i> <br>
        <span class="text-warning">Hold  (init)</span>
    
    @elseif($shipping_status=='8')
        <i class="fa fa-check-square-o fa-3x text-danger"></i> <br>
        <span class="text-danger">Return</span>
    @elseif($shipping_status=='on-8')
        <i class="fa fa-check-square-o fa-3x text-danger"></i> <br>
        <span class="text-danger">Return</span>
    
    @elseif($shipping_status=='9')
        <i class="fa fa-check-square-o fa-3x text-danger"></i> <br>
        <span class="text-danger">Return </span>
    @endif

@else <span class="label label-info">waiting for verification</span> @endif

@elseif($status==2)
<span class="label label-warning">Cancelled</span>
@endif

