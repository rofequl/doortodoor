@if($status=='1')
    @if($shipping_status=='0')
    	<span class="label label-success">Label Create</span>
    @elseif($shipping_status=='1')
    	<span class="label label-info">Pick-up</span>

    @elseif($shipping_status=='2')
    	<span class="label label-primary">Piced-up</span>

    @elseif($shipping_status=='3')
        <span class="label label-primary"> Dispatch Center</span>

    @elseif($shipping_status=='4')
    	<span class="label label-primary">In Transit</span>
    
    @elseif($shipping_status=='5')
    	<span class="label label-primary">Out for delivery</span>

    {{-- multi status  --}}
    @elseif($shipping_status=='6')
        <span class="label label-success">Delivered</span>
    @elseif($shipping_status=='on-6')
        <span class="label label-success">Delivered (init)</span>
    
    @elseif($shipping_status=='6.5')
    	<span class="label label-success">Partial delivery</span>
    @elseif($shipping_status=='on-6.5')
    	<span class="label label-success">Partial delivery (init)</span>

    @elseif($shipping_status=='7')
        <span class="label label-warning">Hold</span>
    @elseif($shipping_status=='on-7')
        <span class="label label-warning">Hold  (init)</span>
    
    @elseif($shipping_status=='8')
        <span class="label label-danger">Return</span>
    @elseif($shipping_status=='on-8')
        <span class="label label-danger">Return (init)</span>
    
    @elseif($shipping_status=='9')
        <span class="label label-danger">Return (to merchant)</span>
        
    @elseif($shipping_status=='10')
        <span class="label label-warning">Hand over to courier</span>
        
    @else
        <span class="label label-warning">not labeled</span> @endif

@elseif($status=='2')
    <span class="label label-warning">Cancelled</span>
@endif

