<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

use Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistrationMail;
use App\Mail\UserVerificationMail;
use App\User_verification;

use App\Mail_configuration;
use Illuminate\Contracts\Session\Session as SessionSession;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::guard('user')->check()) return Redirect('/dashboard');
        return view('auth.login');
    }
    
    public function register()
    {
        if (Auth::guard('user')->check()) return Redirect('/dashboard');
        return view('auth.register');
    }

    public function registerStore(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|max:100|unique:users,email',
            'phone' => 'required|max:15',
            'password' => 'required|max:20|min:8|confirmed',
        ]);

        $user = User::create([
            'user_id' => 'UR' . rand(100, 999) . time(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Auth::guard('user')->login($user);
        
        Session::put('verification_email',$request->email);
        // dd(Session::get('verification_email'));
        $this->send_verification_code();
        return redirect('/verify');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:100',
            'password' => 'required|max:20|min:8',
        ]);


        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            if(Auth::guard('user')->user()->is_verified==1){
                return redirect()->intended('/dashboard');
            }else{
                return redirect()->route('verify-user');
                dd('check email');
            }
        }
        $request->session()->flash('login_error', 'Wrong information or this account not login.');
        return back()->withInput($request->only('email', 'remember'));
    }

    public function verify()
    {
        if (Auth::guard('user')->check()) {  
            Session::put('verification_email',Auth::guard('user')->user()->email);
            Auth::guard('user')->logout();
        }
        if(!Session::has('verification_email')){
            return redirect('/login');
        }
        return view('auth.verify');
    }

    function verify_code(Request $request)
    {
       $check = User_verification::where([
        'verification_code'=>$request->verification_code,
        'status'=>'waiting'
       ])->first();
       if($check==null){
         return back()->with('message','Verification code does not match!');
       }else{
         $userinfo = User::where('id',$check->user_id)->update(['is_verified'=>'1']);
         $userinfo = User_verification::where('id',$check->id)
         ->update(['status'=>'verified']);
       }
        $user = User::find($userinfo);
		$this->registrationMail($user);
       // Auth::guard('user')->login($user);
       return redirect('/login');
    }


    function send_verification_code(){
        // dd(Session::get('verification_email'));
        $subject =  'Verification code | '.basic_information()->company_name;
        
        $code = rand();
        $user=User::where('email',Session::get('verification_email'))->first();
        $add = User_verification::create([
            'user_id'=>$user->id,'verification_code'=>$code
        ]);
        
        $this->get_config($subject);
        \Mail::to(Session::get('verification_email'))->send(new UserVerificationMail($subject,$code));
        return view('emails.users.UserVerificationMail',compact('subject','code'));
    }


    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        return redirect('/login');
    }

    private function registrationMail($user){
        $email = basic_information()->email;
        if($email !=null){
            $this->get_config('New merchant registered');
            \Mail::to($email)->send(new UserRegistrationMail($user));
            return view('emails.users.UserRegistrationMail',compact('user'));
        }
    }

    public function get_config($subject){
        $data = Mail_configuration::where('type','config')->first();
        // dd($data);
        if($data){
            // $config = array(
            //     'host' =>'smtp.gmail.com',
            //     'port'=>'587',
            //     'encryption'=>'tls',
            //     'username'=>$data->username,
            //     'password'=>$data->password
            // );
            // Config::set('mail', $config);
            Config(['mail.mailers.smtp.username'=>$data->username]);
            Config(['mail.mailers.smtp.password'=>$data->password]);
            Config(['mail.from.address'=>$data->send_email]);
            Config(['mail.from.name'=>$subject]);
        }
    }

}
