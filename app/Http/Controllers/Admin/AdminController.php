<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use App\Admin_role;
use App\Hub;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Hash;
//use this library for uploading image
use Illuminate\Http\UploadedFile;
//user this intervention image library to resize/crop image
use Intervention\Image\Facades\Image; 
// import the Intervention Image Manager Class
use Intervention\Image\ImageManager;

class AdminController extends Controller
{
    public function index()
    {
        $admins= Admin::latest()->get();
        $hubs= Hub::latest()->get();
        return view('admin.admins.index',compact('admins','hubs'));
    }

    public function admins()
    {
        return DataTables::of(Admin::orderBy('id', 'DESC'))
        ->addColumn('action', function ($employee) {
            $data = '<div class="btn-group  btn-group-sm">
                <button class="btn btn-success edit" id="' . $employee->id . '" type="button"><i class="mdi mdi-table-edit m-r-3"></i>Edit</button>';
            if ($employee->role_id=='1') {
                $data .=' <button class="btn btn-info" type="button"><i class="mdi mdi-check m-r-3"></i>Super</button>';
            }else{
                $data .=' <button class="btn btn-danger delete" id="' . $employee->id . '" type="button"><i class="mdi mdi-delete m-r-3"></i>Delete</button>';
            }
            $data .='</div>';  return $data; 
        })
        ->addColumn('employee_info', function ($employee) {  
            if($employee->image==null) $src= 'images/user.png';
            else $src= $employee->image;

            $data = '<img style="height:30px" src="/'.$src.'"> '.$employee->first_name.' '.$employee->last_name.' - '.$employee->phone;
            return $data;
        })
        ->addColumn('email', function ($employee) {
            return $employee->email;
        })
        ->addColumn('address', function ($employee) {
            return $employee->address;
        })->rawColumns(['employee_info','email','address','action'])->make(true);
    }

    public function create()
    {
        $admin= new Admin;
        return view('admin.admins.create',compact('admin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $validator = $this->fields(); 
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $data = [
            'role_id'=>'2', 'first_name'=>$request->first_name, 
            'last_name'=>$request->last_name,
            'email'=>$request->email,'phone'=>$request->phone,
            'password' =>Hash::make($request->password),
            'address'=>$request->address,'hub_id'=>$request->hub_id
        ];
        $admin = Admin::create($data);
        $admin->hubs()->attach($request->hub_ids);

        $this->storeImage($admin);

        return response()->json(['success' => 'Admin hasn been created successfully.']);
    }

    public function show(Request $request)
    {
        return Admin::findOrFail($request->id);
    }

    public function update(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'first_name'=>'required', 'last_name'=>'required',
            'email'=>'required|unique:admins,email,'.$request->id,
            'phone'=>'required','address'=>'required', 
            'hub_ids'=> "required|array|min:1",
            'hub_ids.*'=> "required|distinct|min:1",
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $data = [
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'hub_id'=>$request->hub_id
        ];
        Admin::where('id',$request->id)->update($data);
        $employee = Admin::findOrFail($request->id);
        $employee->hubs()->sync($request->hub_ids);
        $this->storeImage($employee,'update');

        return response()->json(['success' => 'Admin hasn been updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return response()->json(['success' => 'Row hasn been removed successfully.']);
    }

    function role_assign(){
        $admin = new Admin;
        $routes = $admin->admin_routes();
        $employees = Admin::where('role_id','!=',1)->get();
        return view('admin.admins.role.assign-role',compact('employees'));
    }
    function employee_roles(Admin $admin){
        $routes = $admin->admin_routes();
        return view('admin.admins.role.show-routes',compact('admin','routes'));
    }
    function save_role_assign(Request $request){
        Admin_role::where('admin_id',$request->admin_id)->delete();
        if($request->routes){
            foreach ($request->routes as $key => $route) {
                // echo $route.' '.$request->admin_id.'<br/>';
                Admin_role::create([
                    'admin_id'=>$request->admin_id,
                    'route'=>$route
                ]);
            } 
        }else{
            Admin_role::create([ 'admin_id'=>$request->admin_id,'route'=>'admin' ]);
        }
        return back()->with('message','Permission has been changes successfullyl!!');
    }




    private function fields($id=null){
        $validator = Validator::make(request()->all(), [
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|unique:admins,email,'.$id,
            'phone'=>'required',
            'password' => 'required|confirmed|min:3',
            'password_confirmation' => 'required|min:3',
            'address'=>'required',
            'hub_ids'=> "required|array|min:1",
            'hub_ids.*'=> "required|distinct|min:1",
            'image'=>'sometimes|nullable',
        ]); return $validator;
    }

    function storeImage($admin,$type=null){
        if (request()->has('image')) {
            $fileName = rand().'.'.request()->image->extension();  
            request()->image->move('images/admin/', $fileName);
            Image::make('images/admin/'.$fileName)->fit(100,100)->save();
            $admin->update(['image'=>'images/admin/'.$fileName]);
            if ($type=='update') {
                \File::delete(request()->oldLogo);
            }
        }
    }
}
