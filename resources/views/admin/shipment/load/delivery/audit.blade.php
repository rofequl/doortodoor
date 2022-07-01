<table class="table table-striped">
  <thead>
    <tr class="bg-dark">
      <th>Parcel</th>
      <th>Time</th>
      <th>Comment</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($audit_logs as $key=>$log)
    @if($key==0)
    <tr>
      <td>Status: <b class="budge">label Created</b> <br>Merchant: {{$shipment->user->first_name}} {{$shipment->user->last_name}}</td>
      <td>{{date('M d, y',strtotime($shipment->created_at))}} <br>
        {{date('H:i:s',strtotime($shipment->created_at))}}</td>
      <td>@if($shipment->merchant_note==null)N/A @else $shipment->merchant_note @endif</td>
    </tr>
    @endif

    @if($log->status == 'pickup' && $log->user_type=='driver')
    <tr>
      <td>Status: {{$log->status}} <br>
        <?php $admin_id =  \DB::table('driver_shipment')->where(['driver_id'=>$log->user_id,'shipment_id'=>$log->shipment_id])->pluck('admin_id')->first();
        $admin = \DB::table('admins')->select('first_name','last_name')->where('id',$admin_id)->first();?>

        Assigned by: {{$admin->last_name.' '.$admin->last_name}} <br>

        Driver: <?php $driver = \DB::table('drivers')->select('first_name','last_name')->where('id',$log->user_id)->first(); echo $driver->first_name.' '.$driver->last_name; ?><br>
      </td>
      <td>{{date('M d, y',strtotime($log->created_at))}} <br>
        {{date('H:i:s',strtotime($log->created_at))}}</td>
      <td>{{$log->note}}</td>
    </tr>
    @endif

    <tr>
      <td>Status: <b class="budge">{{$log->status}}</b> <br>
        @if($log->user_type=='admin')
        <?php  $admin = \DB::table('admins')->select('first_name','last_name')->where('id',$log->user_id)->first();?>
        Performed by: {{$admin->first_name}} {{$admin->last_name}}
        @endif

        @if($log->user_type=='driver')
        <?php  $driver = \DB::table('drivers')->select('first_name','last_name')->where('id',$log->user_id)->first();?>
        Rider: {{$driver->first_name}} {{$driver->last_name}}
        @endif
      </td>
      <td>{{date('M d, y',strtotime($log->created_at))}} <br>
        {{date('H:i:s',strtotime($log->created_at))}}</td>
      <td>@if($log->note==null)N/A @else {{$log->note}} @endif</td>
    </tr>
    @endforeach
    
  </tbody>
</table>