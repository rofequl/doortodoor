@if($status=='1')
    @if($shipping_status=='0')
    	<span class="text-success">Label Create</span>
    @elseif($shipping_status=='1')
    	<span class="text-info">Pick-up</span>

    @elseif($shipping_status=='2')
    	<span class="text-primary">Pic-up</span>

    @elseif($shipping_status=='3')
        <span class="text-primary"> Dispatch Center</span>

    @elseif($shipping_status=='4')
    	<span class="text-primary">In Transit</span>
    
    @elseif($shipping_status=='5')
    	<span class="text-primary">Out for delivery</span>

    {{-- multi status  --}}
    @elseif($shipping_status=='6')
        <span class="text-success">Delivered</span>
    @elseif($shipping_status=='on-6')
        <span class="text-success">Delivered (init)</span>
    
    @elseif($shipping_status=='6.5')
    	<span class="text-success">Partial delivery</span>
    @elseif($shipping_status=='on-6.5')
    	<span class="text-success">Partial delivery (init)</span>

    @elseif($shipping_status=='7')
        <span class="text-warning">Hold</span>
    @elseif($shipping_status=='on-7')
        <span class="text-warning">Hold  (init)</span>
    
    @elseif($shipping_status=='8')
        <span class="text-danger">Return</span>
    @elseif($shipping_status=='on-8')
        <span class="text-danger">Return (init)</span>
    @elseif($shipping_status=='9')
        <span class="text-danger">Return (to merchant)</span>
    @elseif($shipping_status=='10')
        <span class="text-success">Hand over to courier</span>
    @else
        <span class="text-warning">not labeled</span> @endif

@elseif($status=='2')
    <span class="text-warning">on-process</span>
@endif

