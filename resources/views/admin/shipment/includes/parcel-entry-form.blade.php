
    <div class="row">
    	<div class="col-md-6">
			<label class="" for="name">Customer Name</label>
            <input type="text" id="name" class="form-control" name="name" required>
		</div>
        <div class="col-md-6">
            <label for="usr3">Phone Number</label>
            <input type="text" class="form-control" name="phone" required>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-md-12">
            <label class="" for="address">Address</label>
            <input type="text" id="address" class="form-control" name="address" required>
        </div>
    </div>
    <div class="row my-4">
    	<div class="col-md-6 text-left">
            <label for="zip_code">Zip Code</label>
            <input type="text" id="zip_code" class="form-control" name="zip_code">
        </div>
        <div class="col-md-6 text-left">
            <label for="area">Area</label>
            <?php $area = \DB::table('areas')->get();?>
            <select  class="form-control select2" style="width:100%;height:35px" name="area" id="area" required>
                <option value="" selected disabled>Select area</option>
                @foreach($area as $areas)
                        <option value="{{$areas->id}}">{{$areas->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <h5 class="card-title mt-4">Shipment Details:</h5>
    <div class="row my-4">
        <div class="col-md-4 text-left">
            <label class="" for="weight">Weight</label>
            <input type="text" id="weight" class="form-control" name="weight" value="1">
  
        </div>
        <div class="col-md-4 cod_target text-left">
            <label for="parcel_value">Declared Parcel Value</label>
            <input type="number" id="parcel_value" class="form-control" name="parcel_value" value="0">

        </div>

        <div class="col-md-4 text-left">
            <label for="invoice_id">Invoice Id</label>
            <input type="text" id="invoice_id" class="form-control" name="invoice_id" value="{{rand()}}">
        </div>
    </div>
    <div class="row my-4">
        <div class="col-md-12 text-left">
            <label for="merchant_note">Merchant Note</label>
            <textarea id="merchant_note" class="form-control" rows="3" name="merchant_note"></textarea>
        </div>
    </div>
    <div class="row"> <br>
        <label class="col-md-3">Delivery Type:</label>
        <div class="col-md-4">
            <label class="radio-inline"><input type="radio" value="1" name="delivery_type" checked>Regular</label>
			<label class="radio-inline"><input type="radio" value="2" name="delivery_type">Express</label> 
        </div>
    </div>
