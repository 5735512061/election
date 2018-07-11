<?php

namespace App\Http\Controllers\AuthAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    public function __construct()
    {
      //return 'admin';
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('authAdmin.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
          'email' => 'required|email',
          'password' => 'required|min:6'
        ],[
          'email.required' => "กรุณากรอกอีเมล",
          'email.email' => "กรุณากรอกที่อยู่อีเมลให้ถูกต้อง",
          'password.required' => "กรุณากรอกรหัสผ่าน",
          'password.min' => "กรุณากรอกรหัสผ่านอย่างน้อย 6 ตัวอักษร",
        ]);


        $credential = [
          'email' => $request->email,
          'password' =>$request->password,
          'status'=> '1'
        ];

       if(Auth::guard('admin')->attempt($credential, $request->member)){
         return redirect()->intended(route('admin.home'));
       }
       
       return redirect()->back()->withInput($request->only('email','remember'));
    }

}
