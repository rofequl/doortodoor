<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Blog_category;
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

class Blog_categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.website_manage.blog.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function categories()
    {
        return DataTables::of(Blog_category::latest()->get())->addColumn('action', function ($about) {
            $data = '<div class="btn-group btn-group-sm">
                <button class="btn btn-success edit" id="' . $about->id . '" type="button"><i class="mdi mdi-table-edit m-r-3"></i>Edit</button>';

            $data .=' <button class="btn btn-danger delete" id="' . $about->id . '" type="button"><i class="mdi mdi-delete m-r-3"></i>Delete</button>';

            $data .='</div>';  return $data; 
        })
        ->addColumn('photo', function ($about) {
            if($about->photo !=null){
                return $photo = '<img src="/'.$about->photo.'" style="height:30px">';
            }
        })
        ->addColumn('name', function ($about) {  
           return $about->name.' (<b>'.$about->blogs->count().'</b>)';
        })
        ->addColumn('status', function ($about) {
            if($about->status=='1'){
                $data = '<button clas="btn btn-xs btn-success"><i class="fa fa-check"></i> Published</button>';
            }else{
                $data = '<button clas="btn btn-xs btn-warning"><i class="fa fa-times-circle"></i> Not-published</button>';
            } return $data;
        })
        ->rawColumns(['photo','name','status','action'])->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (empty($request->name)) {
           echo '<h4 class="alert alert-danger"> Request fields are been empty!!</h4>';exit;
        }

        $data = [
            'name'=>$request->name,
            'status'=>$request->status
        ];
        $category = Blog_category::create($data);
        // print_r($data);

        $this->storeImage($category);
        echo '<p class="alert alert-danger"> BLog category hasn been created successfully!</p>';
        // return response()->json(['success' => 'BLog category hasn been created successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Blog_category::find($id);
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
        if (empty($request->name)) {
           echo '<h4 class="alert alert-danger"> Request fields are been empty!!</h4>';exit;
        }

        $data = [
            'name'=>$request->name,
            'status'=>$request->status
        ];
        Blog_category::where('id',$request->id)->update($data);
        $category = Blog_category::findOrFail($request->id);
        // print_r($data);
        $this->storeImage($category,'update');

        echo  '<h4 class="alert alert-success"> Category hasn been updated successfully.</h4>';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog_category $blog_category)
    {
        $blog_category->delete();
        return response()->json(['success' => 'Category hasn been deleted successfully.']);
    }

    function storeImage($blog_category,$type=null){
        if (request()->has('photo')) {
            $fileName = rand().'.'.request()->photo->extension();  
            request()->photo->move('images/blog/category/', $fileName);
            Image::make('images/blog/category/'.$fileName)->fit(100,100)->save();
            $blog_category->update(['photo'=>'images/blog/category/'.$fileName]);
            if ($type=='update') {
                \File::delete(request()->oldLogo);
            }
        }
    }
}
