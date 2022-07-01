<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Hub;
use App\Admin;
use Session; use Auth;
class DashboardController extends Controller
{
    public function index()
    {
        $hub = \App\Admin_hub::where('admin_id',Auth::guard('admin')->user()->id)->first();
        if($hub!=null){
            Session::put('admin_hub',$hub);
        }        
        return view('admin.dashboard');
    }

    public function admin_changes_hub(Hub $hub)
    {
        Session::put('admin_hub',$hub);
        return back();
    }

    public function store(Request $request)
    {
        //
    }

    public function get_admin_hub_ids(Admin $admin)
    {
        $hubs = \App\Admin_hub::where('admin_id',$admin->id)->get();
        $ids = array();
        foreach ($hubs as $key => $value) {
            $ids[] = $value->hub_id;
        }
        return implode(',',$ids);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
