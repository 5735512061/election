<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Image;
use App\Header;
use App\Admin;
use App\Area;
use Redirect;
use Hash;
use Validator;
use DB;


class MasterController extends Controller
{
  public function showChangePasswordForm(){
    return view('master/master_changePassword');
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

    public function index()
    {
      return view('master/master_add');
    }

    public function profile()
    {
        return view('master/master_profile', array('user' => Auth::user()));
    }

    public function update_avatar(Request $request)
    {
      $validator = Validator::make($request->all(), $this->rulesprofile(), $this->messagesprofile());
      if ($validator->passes()) {
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
      else {
            return back()->withErrors($validator)->withInput();
      }

    }

    public function add_header(Request $request)
    {
      $validator = Validator::make($request->all(), $this->rules(), $this->messages());
      if ($validator->passes()) {
      $header = request()->all();
      $header['image'] = 'profile.jpg';
      $header['password'] = bcrypt($header['password']);
      Header::create($header);
      return redirect()->action('HomeController@index');
      }
      else {
            return back()->withErrors($validator)->withInput();
      }
    }

    public function edit_header($id)
    {
      $header = Header::findOrFail($id);
      return view('master/master_edit')->with('header', $header);
    }

    public function update_header(Request $request)
    {
      $id = $request->get('header_id');
      $validator = Validator::make($request->all(), $this->rulesupdate($id), $this->messagesupdate());
      if ($validator->passes()) {
        if($request->hasFile('avatar'))
        {
          $avatar = $request->file('avatar');
          $filename = time() . '.' . $avatar->getClientOriginalExtension();
          Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/' . $filename ) );
          $header = Header::findOrFail($id);
          $header->update($request->all());
          $header->image = $filename;
          $header->save();

        }
          $header = Header::findOrFail($id);
          $header->update($request->all());
          $header->save();
          return back();

      }
        else {
          return back()->withErrors($validator)->withInput();
        }
    }

    public function block_header(Request $request,$id)
    {

      $header = Header::findOrFail($id);
      if($header->status == '1' )
        $header->update(['status' => '0']);
      else
        $header->update(['status' => '1','comment'=>null]);
      return back();
    }

    public function master_showadmin(Request $request, $id)
    {
        $NUM_PAGE = 5;
        $admins = Admin::where('header_id',$id)
                       ->orderBy('updated_at','desc')
                       ->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        $header = Header::findOrFail($id);
        return view('master/master_showadmin')->with('admins',$admins)
                                            ->with('header',$header)
                                            ->with('page',$page)
                                            ->with('NUM_PAGE',$NUM_PAGE);
    }
    public function master_showarea(Request $request, $id)
    {
        $NUM_PAGE = 5;
        $areas = Area::where('admin_id',$id)
                      ->orderBy('updated_at','desc')
                      ->paginate($NUM_PAGE);
        $scores = DB::select('SELECT `score`,`area_id` FROM `scores`');
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        $admin = Admin::findOrfail($id);
        $header= Header::findOrfail($admin->header_id);
        return view('master/master_showarea')->with('areas',$areas)
                                             ->with('header',$header)
                                             ->with('page',$page)
                                             ->with('NUM_PAGE',$NUM_PAGE)
                                             ->with('scores',$scores);
    }

    public function search(Request $request)
    {
      $NUM_PAGE = 5;
      $key = $request->get('key');
      $headers = Header::where('header_name','like','%'.$key.'%')
                      ->orderBy('updated_at','desc')
                      ->paginate($NUM_PAGE);
      $page = $request->input('page');
      $page = ($page != null)?$page:1;

      return view('master/master_home')->with('headers',$headers)
                                       ->with('page',$page)
                                       ->with('NUM_PAGE',$NUM_PAGE);
      }

    public function rules() {
        return [
          'name' => 'required',
          'password' => 'required|min:6',
          'email' => 'email|required|unique:headers',
          'tel' => 'required|regex:/(0)[0-9]{9}/',
          'header_name' => 'required',
          'district' => 'required',
          'amphoe' => 'required',
          'province' => 'required',
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
          'header_name.required' => 'กรุณากรอกชื่อสมาชิกพรรค',
          'district.required' => 'กรุณากรอกตำบล',
          'amphoe.required' => 'กรุณากรอกอำเภอ',
          'province.required' => 'กรุณากรอกจังหวัด',
        ];
    }

    public function rulesupdate($id) {
        return [
          'name' => 'required',
          'email' => 'email|required|unique:headers,email,'.$id,
          'tel' => 'required|regex:/(0)[0-9]{9}/',
          'header_name' => 'required',
          'district' => 'required',
          'amphoe' => 'required',
          'province' => 'required',
        ];
    }

    public function messagesupdate() {
        return [
          'name.required' => 'กรุณากรอกชื่อ',
          'email.required' => 'กรุณากรอกอีเมล',
          'email.email' => 'กรอกที่อยู่อีเมลให้ถูกต้อง',
          'email.unique' => 'อีเมลนี้มีผู้ลงทะเบียนแล้ว',
          'tel.required' => 'กรุณากรอกเบอร์โทรศัพท์',
          'tel.regex' => 'กรอกเบอร์โทรศัพท์ให้ถูกต้อง',
          'header_name.required' => 'กรุณากรอกชื่อสมาชิกพรรค',
          'district.required' => 'กรุณากรอกตำบล',
          'amphoe.required' => 'กรุณากรอกอำเภอ',
          'province.required' => 'กรุณากรอกจังหวัด',
        ];
    }
    public function rulesprofile() {
        return [
          'name' => 'required',
          'email' => 'email|required|unique:users,email,'.Auth::user()->id,
          'tel' => 'required|regex:/(0)[0-9]{9}/',
          'master_name' => 'required',
          'province' => 'required',
        ];
    }

    public function messagesprofile() {
        return [
          'name.required' => 'กรุณากรอกชื่อ',
          'email.required' => 'กรุณากรอกอีเมล',
          'email.email' => 'กรอกที่อยู่อีเมลให้ถูกต้อง',
          'email.unique' => 'อีเมลนี้มีผู้ลงทะเบียนแล้ว',
          'tel.required' => 'กรุณากรอกเบอร์โทรศัพท์',
          'tel.regex' => 'กรอกเบอร์โทรศัพท์ให้ถูกต้อง',
          'master_name.required' => 'กรุณากรอกชื่อหัวหน้าพรรค',
          'province.required' => 'กรุณากรอกจังหวัด',
        ];
    }
    public function score_total(Request $request)
    {
       $NUM_PAGE = 5;
       $headers = Header::where('master_id',Auth::user()->id)
                        ->orderBy('updated_at','desc')
                        ->paginate($NUM_PAGE);
       $page = $request->input('page');
       $page = ($page != null)?$page:1;
         return view('master/master_total')->with('headers',$headers)
                                           ->with('page',$page)
                                           ->with('NUM_PAGE',$NUM_PAGE);
     }
     public function block(Request $request,$id)
     {
       $note = $request->note;
       if($note!=null){
       $header = Header::findOrFail($id);
       $header->update(['status' => '0','comment' => $note]);
         return back();
       }
       else{
         return back();
       }
     }



}
