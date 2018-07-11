<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
       protected $redirectTo = 'master/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'master_name' => 'required|string|max:255',
            'party_name' => 'required|string|max:255',
            'tel' => 'required|regex:/(0)[0-9]{9}/',
            'province' => 'required|string|max:255',
        ],[
           'name.required' => 'กรุณากรอกชื่อจริง',
           'name.string' => 'กรุณากรอกชื่อเป็นข้อความ',
           'name.max' => 'กรุณากรอกชื่อความยาวไม่เกิน 255',
           'email.required' => 'กรุณากรอกอีเมล',
           'email.email' => 'กรอกที่อยู่อีเมลให้ถูกต้อง',
           'email.unique' => 'อีเมลนี้มีผู้ลงทะเบียนแล้ว',
           'email.max' => 'กรุณากรอกอีเมลความยาวไม่เกิน 255',
           'password.required' => 'กรุณากรอกรหัสผ่าน',
           'password.string' => 'กรุณากรอกรหัสผ่านเป็นข้อความ',
           'password.min' => 'กรุณากรอกรหัสผ่านอย่างน้อย 6 ตัวอักษร',
           'password.confirmed' => 'กรุณากรอกรหัสผ่านให้ตรงกัน',
           'master_name.required' => 'กรุณากรอกชื่อเข้าใช้งาน',
           'master_name.string' => 'กรุณากรอกชื่อเข้าใช้งานเป็นข้อความ',
           'master_name.max' => 'กรุณากรอกชื่อเข้าใช้งานความยาวไม่เกิน 255',
           'party_name.required' => 'กรุณากรอกชื่อพรรค',
           'party_name.string' => 'กรุณากรอกชื่อพรรคเป็นข้อความ',
           'party_name.max' => 'กรุณากรอกชื่อพรรคความยาวไม่เกิน 255',
           'tel.required' => 'กรุณากรอกเบอร์โทรศัพท์',
           'tel.regex' => 'กรอกเบอร์โทรศัพท์ให้ถูกต้อง',
           'province.required' => 'กรุณากรอกจังหวัด',
           'province.string' => 'กรุณากรอกจังหวัดเป็นข้อความ',
           'province.max' => 'กรุณากรอกจังหวัดความยาวไม่เกิน 255',


        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'master_name' => $data['master_name'],
            'party_name' => $data['party_name'],
            'tel' => $data['tel'],
            'province' => $data['province'],
            'image' =>  'profile.jpg',
        ]);
    }
}
