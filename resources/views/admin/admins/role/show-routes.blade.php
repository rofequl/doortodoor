
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
        <tr class="bg-dark">
            <th>SL</th>
            <th>Access Route</th>
            <th class="text-right"><label for="all" onclick="checkAll()">Check <input type="checkbox" id="all"></label></th>
        </tr>
        </thead>
        <input type="hidden" name="admin_id" value="{{$admin->id}}">
        @foreach($routes as $key=>$route)
        <tr>
            <td>{{$key+1}}</td>
            <td><b><?php echo $newRoute = preg_replace("%/{.*?}%", '', str_replace('-',' ',$route));?></b> </td>
            <td class="text-right">
                <input type="checkbox" class="checkbox pull-right" value="{{preg_replace('%/{.*?}%', '', $route)}}" name='routes[]' @if(is_admin_allow($admin->id,preg_replace('%/{.*?}%', '', $route)) >0 || $key==0)checked @endif />
            </td>
        </tr>
        @endforeach
    </table>
</div>


<script >

    function checkAll() {
        if($('#all').prop("checked") == true){
            $('.checkbox').prop('checked',true)
        }else if($('#all').prop("checked") == false){
            $('.checkbox').prop('checked',false)
        }        
    }

</script>
