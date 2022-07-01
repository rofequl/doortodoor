<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\About;
use Session;
use DataTables;
use Validator;
class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(About::find(1)==null) $about = new About;
        else $about = About::find(1);
        return view('admin.website_manage.about.index',compact('about'));
    }


    public function store(Request $request)
    {
      
        if(empty(strip_tags($request->description))){
            // echo 'empty';
            return back()->with('message','Description field is need to setUp!');
        }
        $data = [
            'title'=>'About Us',
            'description'=>$request->description,
            'status'=>'1'
        ];
        if($request->submit=='save'){
            About::create($data);
            return back()->with('message','Initional setup is Created for About us page!');
        }else{
            About::where('id',1)->update($data);
            return back()->with('message','Initional setup is updated for About us page!');
        }
        
    }

    public function save(Request $request)
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
        $slider = About::create($data);
        return response()->json(['success' => 'ABout-post hasn been created successfully.']);
    }


    function about_posts(){
         return DataTables::of(About::where('id','!=', '1')->get())->addColumn('action', function ($about) {
            $data = '<div class="btn-group btn-group-sm">
                <button class="btn btn-success edit" id="' . $about->id . '" type="button"><i class="mdi mdi-table-edit m-r-3"></i>Edit</button>';

            $data .=' <button class="btn btn-danger delete" id="' . $about->id . '" type="button"><i class="mdi mdi-delete m-r-3"></i>Delete</button>';

            $data .='</div>';  return $data; 
        })
     
        ->addColumn('title', function ($about) {  
           return $about->title;
        })
        ->addColumn('description', function ($about) {
            if (strlen($about->description) > 80) {
                return substr($about->description, 0, 80).' ...';
            }else return $about->description;
        })
        ->addColumn('status', function ($about) {
            if ($about->status=='1') {
                $data =' <button class="btn btn-info btn-xs pull-right" type="button"><i class="mdi mdi-check m-r-3"></i>Published</button>';
            }else{
                $data =' <button class="btn btn-warning btn-xs pull-right" type="button"><i class="mdi mdi-times m-r-3"></i>Unpublished</button>';
            }
            return $data; 
        })->rawColumns(['title','description','status','action'])->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return About::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        About::where('id',$request->id)->update($data);

        return response()->json(['success' => 'Post hasn been updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(About $about)
    {
        $about->delete();
        return response()->json(['success' => 'Post hasn been updated successfully.']);
    }

     private function fields($id=null){
        $validator = Validator::make(request()->all(), [
            'title'=>'required',
            'description'=>'required',
            'status'=>'required'
        ]); return $validator;
    }

}
