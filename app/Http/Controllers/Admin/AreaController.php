<?php

namespace App\Http\Controllers\Admin;

use App\Area;
use App\Http\Controllers\Controller;
use App\Hub;
use App\Zone;
use Illuminate\Http\Request;
use Session;
use DataTables;

class AreaController extends Controller
{
    public function index()
    {
        $zone = Zone::all();
        return view('admin.area.hub', compact('zone'));
    }

    public function hubGet()
    {
        return DataTables::of(Hub::orderBy('id', 'DESC')->get())->addColumn('action', function ($country) {
            return '
            <div class="btn-group  btn-group-sm">
                <button class="btn btn-success edit" id="' . $country->id . '" type="button"><i class="mdi mdi-table-edit m-r-3"></i>Edit</button>
                <button class="btn btn-danger delete" id="' . $country->id . '" type="button"><i class="mdi mdi-delete m-r-3"></i>Delete</button>
              </div>';
        })->addColumn('status', function ($country) {
            if ($country->status == 1) {
                return "<button type = 'button' id = '$country->id' class='btn btn-success btn-xs Change'> Active</button>";
            } else {
                return "<button type = 'button' id = '$country->id' class='btn btn-info btn-xs Change'> Inactive</button>";
            }
        })->addColumn('zone', function ($country) {
            return Zone::where('id', $country->zone_id)->pluck('name')->first();
        })->rawColumns(['status', 'action'])->make(true);
    }

    public function hubUpdate(Request $request)
    {
        if ($request->action == 'inactive') {
            $insert = Hub::find($request->id);
            $insert->status = 0;
            $insert->save();
        } else {
            $insert = Hub::find($request->id);
            $insert->status = 1;
            $insert->save();
        }
    }

    public function hubStore(Request $request)
    {
        $this->validate($request, [
            'zone_id' => 'Required',
            'name' => 'Required|max:255|unique:hubs,name,' . $request->id,
        ]);

        if ($request->id == '') {
            $insert = new Hub();
        } else {
            $insert = Hub::find($request->id);
        }
        $insert->zone_id = $request->zone_id;
        $insert->name = $request->name;
        $insert->save();

        return 1;
    }

    public function hubGetSingle(Request $request)
    {
        return Hub::findOrFail($request->id);
    }

    public function SelectHub(Request $request)
    {
        $earth = Hub::where('zone_id', $request->id)->where('status', 1)->get();
        return json_encode($earth);
    }

    public function delete_hub(Hub $hub)
    {   
        if(\Auth::guard('admin')->user()->role_id !='1') return 0;
        $area = Area::where('hub_id',$hub->id)->count();
        if($area > 0) return 0;
        $hub->delete(); return 1;
    }


    public function zone(){ return view('admin.area.zone');}

    public function zoneGet()
    {
        return DataTables::of(Zone::orderBy('id', 'DESC'))->addColumn('action', function ($country) {
            return '<div class="btn-group  btn-group-sm">
                <button class="btn btn-success edit" id="' . $country->id . '" type="button"><i class="mdi mdi-table-edit m-r-3"></i>Edit</button>
                <button class="btn btn-danger delete" id="' . $country->id . '" type="button"><i class="mdi mdi-delete m-r-3"></i>Delete</button>
            </div> ';
        })->addColumn('status', function ($country) {
            if ($country->status == 1) {
                return "<button type = 'button' id = '$country->id' class='btn btn-success btn-xs Change'> Active</button>";
            } else {
                return "<button type = 'button' id = '$country->id' class='btn btn-info btn-xs Change'> Inactive</button>";
            }
        })->rawColumns(['status', 'action'])->make(true);
    }

    public function zoneStore(Request $request)
    {
        $this->validate($request, [
            'name' => 'Required|max:255|unique:zones,name,' . $request->id,
        ]);

        if ($request->id == '') {
            $insert = new Zone();
        } else {
            $insert = Zone::find($request->id);
        }
        $insert->name = $request->name;
        $insert->save();

        return 1;
    }

    public function zoneUpdate(Request $request)
    {
        if ($request->action == 'inactive') {
            $insert = Zone::find($request->id);
            $insert->status = 0;
            $insert->save();
        } else {
            $insert = Zone::find($request->id);
            $insert->status = 1;
            $insert->save();
        }
    }

    public function zoneDelete(Request $request)
    { 
        $hub = Hub::where('zone_id',$request->id)->count();
        if($hub > 0) { echo 'Foreign key integrated'; return false; }
        else{
            Zone::where('id',$request->id)->delete();
            return true;
        }
    }

    public function zoneGetSingle(Request $request)
    {
        return Zone::findOrFail($request->id);
    }

    public function area()
    {
        $zone = Zone::latest()->get();
        return view('admin.area.area', compact('zone'));
    }

    function areaGetSingle(Request $request){
        return Area::findOrFail($request->id);
    }
    public function areaStore(Request $request)
    {
        // dd($request)
        $this->validate($request, [
            'zone_id' => 'required','hub_id' => 'required',
            'name' => 'required|max:255|unique:areas,name,' . $request->id,
        ]);

        if ($request->id == '') {
            $insert = new Area();
        } else {
            $insert = Area::find($request->id);
        }
        $insert->zone_id = $request->zone_id;
        $insert->hub_id = $request->hub_id;
        $insert->name = $request->name;
        $insert->save();

        return 1;
    }

    public function areaGet()
    {
        return DataTables::of(Area::orderBy('id', 'DESC'))->addColumn('action', function ($country) {
            return '
            <div class="btn-group  btn-group-sm text-right">
                <button class="btn btn-info btn-xs edit" id="'.$country->id.'"><i class="fa fa-edit"></i> Edit</button>
                <button class="btn btn-danger btn-xs delete" id="'.$country->id.'"><i class="fa fa-trash"></i> Delete</button>
            </div>
            ';
        })->addColumn('status', function ($country) {
            if ($country->status == 1) {
                return "<button type = 'button' id = '$country->id' class='btn btn-success btn-xs Change'> Active</button>";
            } else {
                return "<button type = 'button' id = '$country->id' class='btn btn-info btn-xs Change'> Inactive</button>";
            }
        })->addColumn('zone', function ($country) {
            return Zone::where('id', Hub::where('id', $country->hub_id)->pluck('zone_id')->first())->pluck('name')->first();
        })->addColumn('hub', function ($country) {
            return Hub::where('id', $country->hub_id)->pluck('name')->first();
        })->rawColumns(['status', 'action'])->make(true);
    }

    public function areaUpdate(Request $request)
    {
        if ($request->action == 'inactive') {
            $insert = Area::find($request->id);
            $insert->status = 0;
            $insert->save();
        } else {
            $insert = Area::find($request->id);
            $insert->status = 1;
            $insert->save();
        }
    }

    public function areaDelete(Area $area){ 
        $area->delete(); return true;
    }

    // ajax call
    function zone_wize_area(Zone $zone){
        return Area::where('zone_id',$zone->id)->select('id','name')->get();
    }
}
