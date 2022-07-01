<select class="form-control" name="driver_id" required="">
	<option value="">Choose Rider</option>
	@foreach($drivers as $driver)
		<option value="{{$driver->id}}">{{$driver->first_name.' '.$driver->last_name}} ({{$driver->phone}})</option>
	@endforeach
</select>
<br>
<textarea class="form-control" rows="5" placeholder="Type notes (if any)" name="note"></textarea>