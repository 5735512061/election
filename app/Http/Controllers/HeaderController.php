<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Image;
use Hash;
use App\Admin;
use App\Header;
use App\Area;
use App\Score;
use Validator;
use DB;

class HeaderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

     public function showChangePasswordForm(){
       return view('header/header_changePassword');
     }

     public function changePassword(Request $request){
         if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
             // The passwords matches
             return redirect()->back()->with("error","รหัสผ่านปัจจุบันของคุณไม่ตรงกับรหัสผ่านที่คุณระบุ กรุณาลองอีกครั้ง");
         }
         if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
             //Current password and new password are same
             return redirect()->back()->with("error","รหัสผ่านใหม่ต้องไม่เหมือนกับรหัสผ่านปัจจุบันของคุณ โปรดเลือกรหัสผ่านอื่น");
         }
         $validatedData = $request->validate([
             'current-password' => 'required',
             'new-password' => 'required|string|min:6|confirmed',
         ],[
             'current-password.required' => 'กรุณากรอกรหัสผ่านเก่า',
             'new-password.required' => 'กรุณากรอกรหัสผ่านใหม่',
             'new-password.min' => 'กรุณากรอกรหัสผ่านใหม่อย่างน้อย 6 อักษร',
             'new-password.confirmed' => 'กรุณายืนยันรหัสผ่านใหม่',

         ]);
         //Change Password
         $user = Auth::user();
         $user->password = bcrypt($request->get('new-password'));
         $user->save();
         return redirect()->back()->with("success","เปลี่ยนรหัสผ่านสำเร็จ");
     }

    public function __construct()
    {
      //return 'header';
        $this->middleware('auth:header');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $NUM_PAGE = 5;
      $admins = Admin::where('header_id',Auth::user()->id)
                       ->orderBy('updated_at','desc')
                       ->paginate($NUM_PAGE);
      $header = Header::findOrFail(Auth::user()->id);
      $page = $request->input('page');
      $page = ($page != null)?$page:1;

      return view('header/header_home')->with('admins',$admins)
                                       ->with('header',$header)
                                       ->with('page',$page)
                                       ->with('NUM_PAGE',$NUM_PAGE);
    }

    public function add_admin(Request $request)
    {
      $validator = Validator::make($request->all(), $this->rules(), $this->messages());
      if ($validator->passes()) {
      $admin = request()->all();
      $admin['image'] = 'profile.jpg';
      $admin['password'] = bcrypt($admin['password']);
      $admin = Admin::create($admin);

      $admin = Admin::all()->last();
      return redirect()->action('HeaderController@area_admin',['admin_id'=>$admin->id]);
      }
      else {
            return back()->withErrors($validator)->withInput();
      }
    }

    public function rules() {
        return [
          'name' => 'required',
          'password' => 'required|min:6',
          'email' => 'email|required|unique:admins',
          'tel' => 'required|regex:/(0)[0-9]{9}/',
          'admin_name' => 'required|max:255',
        ];
    }

    public function messages() {
        return [
          'name.required' => 'กรุณากรอกชื่อ',
          'password.required' => 'กรุณากรอกรหัสผ่าน',
          'password.min' => 'กรุณากรอกรหัสผ่านอย่างน้อย 6 ตัวอักษร',
          'email.required' => 'กรุณากรอกอีเมล',
          'email.unique' => 'อีเมลนี้มีผู้ลงทะเบียนแล้ว',
          'email.email' => 'กรอกที่อยู่อีเมลให้ถูกต้อง',
          'tel.required' => 'กรุณากรอกเบอร์โทรศัพท์',
          'tel.regex' => 'กรอกเบอร์โทรศัพท์ให้ถูกต้อง',
          'admin_name.required' => 'กรุณากรอกชื่อผู้ดูแลเขต',
          'admin_name.max' => 'กรุณากรอกชื่อผู้ดูแลเขตความยาวไม่เกิน 255 ตัวอักษร',
        ];
    }

    public function register()
    {
      return view('header/header_add');
    }

    public function edit_admin(Request $request, $id)
    {
      $admin = Admin::findOrFail($id);
      $header = Header::findOrFail($admin->header_id);
      return view('header/header_edit')->with('admin', $admin)
                                       ->with('header',$header);
    }

    public function update_admin(Request $request)
    {
      $id = $request->get('admin_id');
      request()->validate([
       'admin_name'  => 'required|max:255',
       'email' => 'email|required',
       'email' => 'email|required|unique:admins,email,'.$id,
       'tel' => 'required|regex:/(0)[0-9]{9}/',
       'name' => 'required|max:255',

      ], [
       'admin_name.required' => 'กรุณากรอกชื่อผู้ดูแลเขต',
       'admin_name.max' => 'กรุณากรอกชื่อผู้ดูแลเขตความยาวไม่เกิน 255 ตัวอักษร',
       'email.required' => 'กรุณากรอกอีเมล',
       'email.unique' => 'อีเมลนี้มีผู้ลงทะเบียนแล้ว',
       'email.email' => 'กรอกที่อยู่อีเมลให้ถูกต้อง',
       'tel.required' => 'กรุณากรอกเบอร์โทรศัพท์',
       'tel.regex' => 'กรอกเบอร์โทรศัพท์ให้ถูกต้อง',
       'name.required' => 'กรุณากรอกชื่อ',
       'name.max' => 'กรุณากรอกชื่อความยาวไม่เกิน 255 ตัวอักษร',

      ]);

      if($request->hasFile('avatar'))
      {
      $avatar = $request->file('avatar');
      $filename = time() . '.' . $avatar->getClientOriginalExtension();
      Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/' . $filename ) );
      $admin = Admin::findOrFail($id);
      $admin->image = $filename;
      $admin->save();
      }
        $admin = Admin::findOrFail($id);
        $admin->update($request->all());
        return back();
    }

    public function block_admin($id)
    {
      $admin = Admin::findOrFail($id);
      if($admin->status == '1' )
        $admin->update(['status' => '0']);
      else
        $admin->update(['status' => '1']);
      return back();
    }

    public function area_admin(Request $request)
    {
      $admin = Admin::findOrFail($request->admin_id);
      $header = Header::findOrFail(Auth::user()->id);
      return view('header/header_area')->with('admin_id',$admin->id)
                                      ->with('header',$header)
                                      ->with('admin_name',$admin->admin_name);
    }

    public function addarea(Request $request)
    {

       request()->validate([
        'admin_id'  => 'required',
        'area_name.*' => 'required|max:255',
       ], [
        'admin_id.required' => 'กรุณาเลือกผู้ดูแลเขต',
        'area_name.*.required' => 'กรุณากรอกชื่อเขต',
        'area_name.*.max' => 'กรุณากรอกชื่อเขตความยาวไม่เกิน 255 ตัวอักษร',
       ]);
       $admin_id = $request->get('admin_id');
       $area_name = $request->get('area_name');

        for($i=0;$i<count($area_name);$i++){
             $data = new Area;
             $data->admin_id = $admin_id;
             $data->area_name = $area_name[$i];
             $data->save();
        }
        return redirect()->action('HeaderController@showarea',['admin_id'=>$admin_id]);
    }

    public function showarea(Request $request,$admin_id){
      $NUM_PAGE = 5;
      $areas = Area::where('admin_id',$request->admin_id)
                   ->orderBy('updated_at','desc')
                   ->paginate($NUM_PAGE);
      $scores = DB::select('SELECT `score`,`area_id` FROM `scores`');
      $page = $request->input('page');
      $page = ($page != null)?$page:1;
      $admin = Admin::findOrFail($request->admin_id);
      $header= Header::findOrFail(Auth::user()->id);
      return view('header/header_showarea')->with('areas',$areas)
                                    ->with('header',$header)
                                    ->with('page',$page)
                                    ->with('admin',$admin)
                                    ->with('NUM_PAGE',$NUM_PAGE)
                                    ->with('scores',$scores);
    }

    public function deletearea($area_id)
    {
        $area = Area::findOrFail($area_id);
        $scores = Score::get();
        foreach($scores as $score){
          $score = Score::where('area_id',$area->id)->delete();
        }
        $area = Area::findOrFail($area_id)->delete();
        return back();
    }

    public function editarea(Request $request, $area_id){
        $area = Area::findOrFail($area_id);
        $admin = Admin::findOrFail($area->admin_id);
        return view('header/header_editarea')->with('area',$area);
    }

    public function updatearea(Request $request,$area_id)
    {
        $area = Area::findOrFail($area_id);
        request()->validate([
         'area_name' => 'required|max:255',
        ], [
         'area_name.required' => 'กรุณากรอกชื่อเขต',
         'area_name.max' => 'กรุณากรอกชื่อเขตความยาวไม่เกิน 255 ตัวอักษร',
        ]);
        $area->update($request->all());
        return redirect()->action('HeaderController@showarea',['admin_id'=>$area->admin_id]);
    }

    public function selectarea(){
        $alladmins = Admin::where('header_id',Auth::user()->id)->get();
        $header = Header::findOrFail(Auth::user()->id);
        return view('header/header_area')->with('alladmins',$alladmins)
                                         ->with('header',$header);
    }

    public function update_avatar(Request $request)
    {
      request()->validate([
        'name' => 'required',
        'email' => 'email|required|unique:headers,email,'.Auth::user()->id,
        'tel' => 'required|regex:/(0)[0-9]{9}/',
        'header_name' => 'required',

      ], [
        'name.required' => 'กรุณากรอกชื่อ',
        'email.required' => 'กรุณากรอกอีเมล',
        'email.email' => 'กรอกที่อยู่อีเมลให้ถูกต้อง',
        'email.unique' => 'อีเมลนี้มีผู้ลงทะเบียนแล้ว',
        'tel.required' => 'กรุณากรอกเบอร์โทรศัพท์',
        'tel.regex' => 'กรอกเบอร์โทรศัพท์ให้ถูกต้อง',
        'header_name.required' => 'กรุณากรอกชื่อสมาชิก',
      ]);
      if($request->hasFile('avatar'))
      {
      $avatar = $request->file('avatar');
      $filename = time() . '.' . $avatar->getClientOriginalExtension();
      Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/' . $filename ) );
      $user = Auth::user();
      $user->update($request->all());
      $user->image = $filename;
      $user->save();
      }
      $user = Auth::user();
      $user->update($request->all());
      return back();

    }

    public function profile()
    {
        return view('header/header_profile', array('user' => Auth::user()));
    }

    public function search(Request $request)
    {
      $NUM_PAGE = 5;
      $key = $request->get('key');
      $admins = Admin::where('admin_name','like','%'.$key.'%')
                     ->orderBy('updated_at','desc')
                     ->paginate($NUM_PAGE);
      $header = Header::findOrFail(Auth::user()->id);
      $page = $request->input('page');
      $page = ($page != null)?$page:1;
      return view('header/header_home')->with('admins',$admins)
                                       ->with('header',$header)
                                       ->with('page',$page)
                                       ->with('NUM_PAGE',$NUM_PAGE);
    }

    public function score_total(Request $request)
    {
      $NUM_PAGE = 5;
      $admins = Admin::where('header_id',Auth::user()->id)
                      ->orderBy('updated_at','desc')
                      ->paginate($NUM_PAGE);
      $header = Header::findOrFail(Auth::user()->id);
      $page = $request->input('page');
      $page = ($page != null)?$page:1;
      return view('header/header_total')->with('admins',$admins)
                                        ->with('header',$header)
                                        ->with('page',$page)
                                        ->with('NUM_PAGE',$NUM_PAGE);
    }
}
