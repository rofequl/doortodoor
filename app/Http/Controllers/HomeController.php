<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Shipment;
use App\Blog;
use App\Blog_category;
use App\Area;
use App\ShippingPrice;

use Validator;
class HomeController extends Controller
{

    public function index()
    {
        $banner = \App\Slider::where('status','1')->first();
        $about = \App\About::where('id','1')->first();
        return view('index',compact('banner','about'));
    }

    public function about()
    {
        $about = \App\About::where('id','1')->first();
        $abouts = \App\About::where('id','!=','1')->where('status','1')->get();
        return view('about',compact('about','abouts'));
    }

    function pricing(){
        return view('pricing');
    }

    public function tracking()
    {
        return view('tracking');
    }
    public function track_order(Request $request){
        // dd($request->all());
        $shipment = Shipment::where('tracking_code',$request->tracking_code)->first();
        return view('includes.tracking-info',compact('shipment'));
    }


    public function contact()
    {
        return view('contact');
    }

    function save_contact(Request $request){
        $data = $this->fields();
        // dd($request->all());
        $message = Message::create($data);
        return back()->with('message','Your Message has been sent successfully!');
    }

    public function blog()
    {
        $categories = Blog_category::orderBy('name')->get();
        $featuresPhotos = Blog::select('photo','id')->inRandomOrder()->limit(9)->get();
        // dd($featuresPhotos);
        $blogs = Blog::latest()->paginate(10);
        return view('blog',compact('blogs','categories','featuresPhotos'));
    }

    function category_post(Blog_category $blog_category){
        $categories = Blog_category::orderBy('name')->get();
        $featuresPhotos = Blog::select('photo','id')->inRandomOrder()->limit(9)->get();
        $blogs = Blog::where('blog_category_id',$blog_category->id)->paginate(10);
        return view('blog',compact('blogs','categories','featuresPhotos'));
    }

    function seach_blog(Request $request){
        $categories = Blog_category::orderBy('name')->get();
        $featuresPhotos = Blog::select('photo','id')->inRandomOrder()->limit(9)->get();
        $keyword = $request->search;
        // dd($keyword);
        $blogs = BLog::query()
           ->where('title', 'LIKE', "%{$keyword}%") 
           ->orWhere('description', 'LIKE', "%{$keyword}%") 
           ->paginate(10);
        return view('blog',compact('blogs','categories','featuresPhotos'));
    }

    function fields(){
        return request()->validate( [
            'name'=>'required',
            'phone'=>'required',
            'email'=>'required|email',
            'message'=>'required|min:15',
        ]); 
    }

    public function rateCheck(Request $request)
    {
        $price = 0;
        $total_price = 0;
        $cod_type = 0;
        $cod_amount = 0;
        
        $zone = Area::find($request->area);
        $shipping = ShippingPrice::where('zone_id', $zone->zone_id)->where('delivery_type', $request->delivery_type)->first();
        if (!$shipping) {
            return ['status' => 'error', 'message' => 'Sorry, not any shipping rate set this zone'];
        }
        if ($shipping->cod == 1) {
            $cod_type = 1;
            if (!$request->parcel_value) {
                // return ['status' => 'error', 'message' => 'Please declared your parcel value first.'];
                $cod_amount = 0;
            } else {
                $cod_amount = (int)(((int)$request->parcel_value / 100) * $shipping->cod_value);
            }
        }

        
        $weight = (float)$request->weight;
        if ($weight > $shipping->max_weight) {
            $ExtraWeight = ($weight - $shipping->max_weight) / $shipping->per_weight;
            if ((int)$ExtraWeight < $ExtraWeight) {
                $ExtraWeight = (int)$ExtraWeight + 1;
            }
            $price = ($ExtraWeight * $shipping->price) + $shipping->max_price;
        } else {
            $price = (int)$shipping->max_price;
        }
        

        $total_price = $price + $cod_amount + (int)$request->parcel_value;

        return ['status' => 'success', 'total_price' => $total_price, 'price' => $price, 'cod' => $cod_type, 'cod_amount' => $cod_amount, 'cod_rate' => $shipping->cod_value];
    }
}
