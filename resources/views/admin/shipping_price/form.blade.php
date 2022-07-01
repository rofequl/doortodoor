
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="zone_id">Distribution
            Zone</label>
        <div class="col-md-7 col-sm-7 col-xs-12">
            <select class="col-md-7 col-xs-12 select2_single" name="zone_id" id="zone_id">
                <option></option>
                @foreach($zone as $zones)
                    <option value="{{$zones->id}}">{{$zones->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group mt-2 text-right">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="cod"
                            id="cod_checkbox">
                    <label class="form-check-label" for="cod_checkbox">
                        COD
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-sm-7 col-xs-12">
            <div class="input-group cod_checkbox_value" id="cod_checkbox_value" style="display: none">
                <input type="number" min="1" name="cod_value" class="form-control" placeholder="Inter COD rate...">
                <span class="input-group-addon" id="priceLabel">%</span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Delivery Type</label>
        <div class="col-md-7 col-sm-7 col-xs-12">
            <div class="row">
                <div class="radio col-sm-6">
                    <label class="radio-inline"><input id="1" type="radio" value="1" name="delivery_type"> Regular</label>
                   
                </div>
                <div class="radio col-sm-6">
                    <label class="radio-inline"><input id="2" type="radio" value="2" name="delivery_type">Express</label>
               
                </div>
            </div>
        </div>
    </div>
    <div class="input-group">
        <input type="number" class="form-control" value="0" readonly>
        <span class="input-group-addon" id="priceLabel">to</span>
        <input type="number" name="max_weight" placeholder="Insert KG"
                class="form-control">
        <span class="input-group-addon" id="priceLabel">kg price</span>
        <input type="number" name="max_price"
                class="form-control" placeholder="Insert Price">
    </div>
    <span class="help-block">Example: 0 to 1 kg price 60 taka</span>
    <div class="input-group">
        <span class="input-group-addon" title="* Price" id="priceLabel">Next per</span>
        <input type="number" placeholder="Insert KG"
                name="per_weight" class="form-control">
        <span class="input-group-addon" id="priceLabel">kg price</span>
        <input type="number" name="price"
                class="form-control" placeholder="Insert Price">
    </div>
    <span class="help-block">Example: Next per 1 KG price 10 Taka</span>

    <div class="ln_solid"></div>
    <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <button class="btn btn-primary" data-dismiss="modal" type="button">Cancel
            </button>
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
    </div>
