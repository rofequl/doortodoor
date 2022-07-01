<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Blog;
use Session; use Auth;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Hash;
//use this library for uploading image
use Illuminate\Http\UploadedFile;
//user this intervention image library to resize/crop image
use Intervention\Image\Facades\Image; 
// import the Intervention Image Manager Class
use Intervention\Image\ImageManager;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('admin.website_manage.blog.index',compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function blogs()
    {
        return DataTables::of(Blog::latest()->get())->addColumn('action', function ($about) {
            $data = '<div class="btn-group btn-group-sm">
                <button class="btn btn-success edit" id="' . $about->id . '" type="button"><i class="mdi mdi-table-edit m-r-3"></i>Edit</button>';

            $data .=' <button class="btn btn-danger delete" id="' . $about->id . '" type="button"><i class="mdi mdi-delete m-r-3"></i>Delete</button>';

            $data .='</div>';  return $data; 
        })
        ->addColumn('photo', function ($about) {
            if($about->photo !=null){
                return $photo = '<img src="/'.$about->photo.'" style="height:30px">';
            }else return '<span class="text-danger">No photo</span>';
        })
        ->addColumn('title', function ($about) {  
           return $about->title;
        })
        ->addColumn('category', function ($about) {  
           return $about->blog_category->name;
        })
        ->addColumn('status', function ($about) {
            if($about->status=='1'){
                $data = '<button clas="btn btn-xs btn-success"><i class="fa fa-check"></i> Published</button>';
            }else{
                $data = '<button clas="btn btn-xs btn-warning"><i class="fa fa-times-circle"></i> Not-published</button>';
            } return $data;
        })
        ->rawColumns(['photo','title','category','status','action'])->make(true);
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
            'admin_id'=>Auth::guard('admin')->user()->id,
            'blog_category_id'=>$request->blog_category_id,
            'title'=>$request->title,
            'description'=>$request->description,
            'status'=>$request->status
        ];
        $blog = Blog::create($data);
        // print_r($data);

        $this->storeImage($blog);

        return response()->json(['success' => 'BLog post hasn been created successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Blog::find($id);
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
        $validator = $this->fields($request->id); 
        // dd($request->all());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
       
        $data = [
            'admin_id'=>Auth::guard('admin')->user()->id,
            'blog_category_id'=>$request->blog_category_id,
            'title'=>$request->title,
            'description'=>$request->description,
            'status'=>$request->status
        ];
        Blog::where('id',$request->id)->update($data);
        $blog = Blog::where('id',$request->id)->first();

        $this->storeImage($blog,'update');

        return response()->json(['success' => 'BLog post hasn been created successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return response()->json(['success' => 'Post hasn been deleted successfully.']);
    }

     private function fields($id=null){
        $validator = Validator::make(request()->all(), [
            'blog_category_id'=>'required',
            'title'=>'required',
            'photo'=>'sometimes|nullable|max:2048|image',
            'description'=>'required',
            'status'=>'required'
        ]); return $validator;
    }

    function storeImage($blog,$type=null){
        if (request()->has('photo')) {
            $fileName = rand().'.'.request()->photo->extension();  
            request()->photo->move('images/blog/', $fileName);
            // Image::make('images/blog/'.$fileName)->fit(100,100)->save();
            $blog->update(['photo'=>'images/blog/'.$fileName]);
            if ($type=='update') {
                \File::delete(request()->oldLogo);
            }
        }
    }
}
