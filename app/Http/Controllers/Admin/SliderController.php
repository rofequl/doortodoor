<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Slider;
use Session;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Hash;
//use this library for uploading image
use Illuminate\Http\UploadedFile;
//user this intervention image library to resize/crop image
use Intervention\Image\Facades\Image; 
// import the Intervention Image Manager Class
use Intervention\Image\ImageManager;

class SliderController extends Controller
{
    public function index()
    {
        $sliders= Slider::latest()->get();
        return view('admin.website_manage.slider.index',compact('sliders'));
    }

    public function sliders()
    {
        return DataTables::of(Slider::orderBy('id', 'DESC')->get())->addColumn('action', function ($slider) {
            $data = '<div class="btn-group btn-group-sm">
                <button class="btn btn-success edit" id="' . $slider->id . '" type="button"><i class="mdi mdi-table-edit m-r-3"></i>Edit</button>';

            $data .=' <button class="btn btn-danger delete" id="' . $slider->id . '" type="button"><i class="mdi mdi-delete m-r-3"></i>Delete</button>';

            $data .='</div>';  return $data; 
        })
     
        ->addColumn('slider_title', function ($slider) {  
            if($slider->photo==null) $src= 'images/user.png';
            else $src= $slider->photo;
            $data = '<img style="height:30px" src="/'.$src.'"> '.$slider->title;
            return $data;
        })
        ->addColumn('description', function ($slider) {
            if (strlen($slider->description) > 80) {
                return substr($slider->description, 0, 80).' ...';
            }else return $slider->description;
        })
        ->addColumn('status', function ($slider) {
            if ($slider->status=='1') {
                $data =' <button class="btn btn-info btn-sm" type="button"><i class="mdi mdi-check m-r-3"></i>Published</button>';
            }else{
                $data =' <button class="btn btn-warning btn-sm" type="button"><i class="mdi mdi-times m-r-3"></i>Unpublished</button>';
            }

            return $data; 
        })->rawColumns(['slider_title','description','status','action'])->make(true);
    }

    public function store(Request $request)
    {
        $validator = $this->fields(); 

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $data = [
            'title'=>$request->title,
            'description'=>$request->description,
            'status'=>$request->status
        ];
        $slider = Slider::create($data);
        // print_r($data);

        $this->storeImage($slider);

        return response()->json(['success' => 'Admin hasn been created successfully.']);
    }

    public function show(Slider $slider)
    {
        return $slider->find($slider->id);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'title'=>'required', 'id'=>'required', 
            'status'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $data = [
            'title'=>$request->title,
            'description'=>$request->description,
            'status'=>$request->status
        ];
        Slider::where('id',$request->id)->update($data);
        $slider = Slider::findOrFail($request->id);
        // print_r($data);
        $this->storeImage($slider,'update');

        return response()->json(['success' => 'Admin hasn been updated successfully.']);
    }

    public function destroy($id)
    {
        //
    }


    private function fields($id=null){
        $validator = Validator::make(request()->all(), [
            'title'=>'required',
            'photo'=>'sometimes|nullable',
            'description'=>'required',
            'status'=>'required'
        ]); return $validator;
    }

    function storeImage($slider,$type=null){
        if (request()->has('photo')) {
            $fileName = rand().'.'.request()->photo->extension();  
            request()->photo->move('images/slider/', $fileName);
            // Image::make('images/slider/'.$fileName)->fit(100,100)->save();
            $slider->update(['photo'=>'images/slider/'.$fileName]);
            if ($type=='update') {
                \File::delete(request()->oldLogo);
            }
        }
    }
}
