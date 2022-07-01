<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Message;
use Session;
use DataTables;
use Validator;
class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.website_manage.message.index');
    }

    public function messages()
    {
        return DataTables::of(Message::latest())->addColumn('action', function ($about) {
            $data = '<div class="btn-group btn-group-sm">
                <button class="btn btn-success show" id="' . $about->id . '" type="button"> View</button>';

            $data .=' <button class="btn btn-danger delete" id="' . $about->id . '" type="button"><i class="mdi mdi-delete m-r-3"></i>Delete</button>';

            $data .='</div>';  return $data; 
        })
     
        ->addColumn('sender', function ($about) {  
           return $about->name.' - '.$about->phone;
        })
        ->addColumn('email', function ($about) {
            return $about->email;
        })
        ->addColumn('message', function ($about) {
            if (strlen($about->message) > 50) {
                return mb_substr($about->message, 0, 50).' ...';
            }else return $about->message;
        })->rawColumns(['name','email','message','action'])->make(true);
    }

    public function show(Message $message)
    {
        return view('admin.website_manage.message.view',compact('message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $message->delete();
        return response()->json(['success' => 'Message has been removed successfully.']);
    }
}
