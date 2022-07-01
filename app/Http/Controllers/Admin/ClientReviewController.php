<?php

namespace App\Http\Controllers\Admin;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use this library for uploading image
use Illuminate\Http\UploadedFile;
//user this intervention image library to resize/crop image
use Intervention\Image\Facades\Image; 
// import the Intervention Image Manager Class
use Intervention\Image\ImageManager;
use App\Client_review;
use DataTables;
class ClientReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Client_review::latest()->get();
        return view('admin.website_manage.client-review.index',compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax_get()
    {
        return DataTables::of(Client_review::orderBy('id', 'DESC'))
        ->addColumn('action', function ($row) {
            $data = '<div class="btn-group  btn-group-sm">
                <button class="btn btn-success edit" id="' . $row->id . '" type="button"><i class="mdi mdi-table-edit m-r-3"></i>Edit</button>';
          
            $data .=' <button class="btn btn-danger delete" id="' . $row->id . '" type="button"><i class="mdi mdi-delete m-r-3"></i>Delete</button>';
            
            $data .='</div>';  return $data; 
        })
        ->addColumn('commenter', function ($row) {  
            if($row->photo==null) $src= 'images/user.png';
            else $src= $row->photo;

            $data = '<img style="height:30px" src="/'.$src.'"> '.$row->commenter;
            return $data;
        })
        ->addColumn('comment', function ($row) {
            return $row->comment;
        })
        ->addColumn('status', function ($row) {
            return $row->status;
        })->rawColumns(['commenter','comment','status','action'])->make(true);
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
            'commenter'=>$request->commenter,
            'comment'=>$request->comment,'status'=>$request->status
        ];
        $client_review = Client_review::create($data);
        // print_r($data);
        $this->storeImage($client_review);
        return response()->json(['success' => 'One Review hasn been created successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Client_review::findOrFail($id);
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
        $validator = $this->fields(); 

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $data = [
            'commenter'=>$request->commenter,
            'comment'=>$request->comment,'status'=>$request->status
        ];
        $client_review = Client_review::find($request->id);
        Client_review::where('id',$request->id)->update($data);

        // print_r($data);
        $this->storeImage($client_review,'update');
        return response()->json(['success' => 'One Review hasn been updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client_review $client_review)
    {
        $client_review->delete();
        return response()->json(['success' => 'Row hasn been removed successfully.']);
    }

    private function fields($id=null){
        $validator = Validator::make(request()->all(), [
            'commenter'=>'required',
            'photo'=>'sometimes|nullable|max:2048',
            'comment'=>'required',
            'status' => 'required'
        ]); return $validator;
    }

    function storeImage($client_review,$type=null){
        if (request()->has('photo')) {
            $fileName = rand().'.'.request()->photo->extension();  
            request()->photo->move('images/reviews/', $fileName);
            Image::make('images/reviews/'.$fileName)->fit(100,100)->save();
            $client_review->update(['photo'=>'images/reviews/'.$fileName]);
            if ($type=='update') {
                \File::delete(request()->oldLogo);
            }
        }
    }
}
