@extends('layouts.app_header')
@section('content')
<div class="container">
  <ol class="breadcrumb">
  				<li class="breadcrumb-item"><a href="{{url('/header')}}">หน้าแรก</a></li>
  				<li class="breadcrumb-item active">แก้ไขข้อมูล</li>
  </ol>
  <form enctype="multipart/form-data" action="{{url('header/profile')}}" method="POST">
<div class="row">
<div class="col-md-3">
<div class="card">
    <div class="card-header">โปรไฟล์
      </div>
      <ul class="list-group list-group-flush">
      <div class="container">
    <div class="row">
        <div class="col-md-1"></div>

      <div class="col-md-9">
        <center>
        <img src="{{url('uploads')}}/{{Auth::user()->image}}" style="width:150px; height:150px;  border-radius:50%; margin-right:25px;">
      <br>
      <lable>อัปโหลดรูปโปรไฟล์</lable>
        </center>
      </div>
      <div class="col-md-9">
          <input type="file" name="avatar">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          {{ csrf_field() }}
      </div>
    </div><br>
    </ul>
</div>
</div>

<div class="col-md-9">
	<div class="card" >
		<div class="card-header">
    	แก้ไขข้อมูล {{Auth::user()->header_name}}
  		</div>
  		<ul class="list-group list-group-flush">
  		<div class="container">
		<div class="row">
		    <div class="col-md-1"></div>
			<div class="col-md-5">
			    <div class="form-group"><br>
  					<label>ชื่อสมาชิก
              @if ($errors->has('header_name'))
              <span class="text-danger">({{ $errors->first('header_name') }})</span>
              @endif
            </label>
  					<input class="form-control" name="header_name" value="{{Auth::user()->header_name}}" type="text">
  				</div>
  				<p>
  					<label>ชื่อเข้าใช้งานระบบ
              @if ($errors->has('name'))
              <span class="text-danger">({{ $errors->first('name') }})</span>
              @endif
            </label>
  					<input class="form-control" name="name" value="{{Auth::user()->name}}" type="text">
  				</p>
          <p>
            <label>ตำบล</label>
            <input class="form-control" value="{{Auth::user()->district}}" disabled>
          </p>
          <p>
            <label>จังหวัด</label>
            <input class="form-control" value="{{Auth::user()->province}}" disabled>
          </p>

  			</div>
			<div class="col-md-5"><br>
				<p>
  					<label>อีเมลเข้าใช้งานระบบ
              @if ($errors->has('email'))
              <span class="text-danger">({{ $errors->first('email') }})</span>
              @endif
            </label>
  					<input class="form-control" name="email" value="{{Auth::user()->email}}" type="text">
  				</p>
          <p>
  					<label>เบอร์โทรศัพท์
              @if ($errors->has('tel'))
              <span class="text-danger">({{ $errors->first('tel') }})</span>
              @endif
            </label>
  					<input class="form-control" name="tel" value="{{Auth::user()->tel}}" type="text">
  				</p>
          <p>
            <label>อำเภอ</label>
            <input class="form-control" value="{{Auth::user()->amphoe}}" disabled>
          </p>



				<input type="hidden" class="form-control" name="master_id" value="{{Auth::user()->master_id}}">
        <input type="hidden" class="form-control" name="province" value="{{Auth::user()->province}}">
        <input type="hidden" class="form-control" name="amphoe" value="{{Auth::user()->amphoe}}">
        <input type="hidden" class="form-control" name="district" value="{{Auth::user()->district}}">
			</div>
		    <div class="col-md-1"></div>
          </div>
          <div class="row">
			     <div class="col-md-6"></div>
			     <div class="col-md-5"><div align="right">
			     <button type="submit" class="btn btn-warning">อัพเดตข้อมูล</button><br><br></div></div>
			     <div class="col-md-1"></div>
          </div>

		</div>
		</ul>
	</div>
</div>
</div>
</form>
</div>
@endsection
