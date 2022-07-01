<?php

namespace App\Http\Controllers\Admin;

use App\BasicInformation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail_configuration;
class BasicInformationController extends Controller
{
    public function index()
    {
        return view('admin.website_manage.basic_information');
    }

    public function update(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000'
        ]);

        $insert = BasicInformation::find($request->id);
        $insert->website_title = $request->website_title;
        $insert->company_name = $request->company_name;
        $insert->meet_time = $request->meet_time;
        $insert->phone_number_one = $request->phone_number_one;
        $insert->phone_number_two = $request->phone_number_two;
        $insert->email = $request->email;
        $insert->website_link = $request->website_link;
        $insert->facebook_link = $request->facebook_link;
        $insert->twiter_link = $request->twiter_link;
        $insert->google_plus_link = $request->google_plus_link;
        $insert->linkedin_link = $request->linkedin_link;
        $insert->footer_text = $request->footer_text;
        $insert->address = $request->address;
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileStore3 = rand(10, 100) . time() . "." . $extension;
            $request->file('image')->storeAs('public/logo', $fileStore3);
            $insert->company_logo = $fileStore3;
        }
        $insert->save();
        return redirect('admin/basic-information');
    }

    public function mailing_info()
    {
        $info = Mail_configuration::where('type','config')->first();
        return view('admin.settings.mail_configuration',compact('info'));
    }

    function save_mailing_info(Request $request){
        Mail_configuration::where('type','config')->update([
            'username'=>$request->username,
            'password'=>$request->password,
            'send_email'=>$request->send_email
        ]);
       
        return back()->with('message','Configuring email setup updated successfully!','success');
    }
}
