@extends('layouts.app_admin')
@section('content')
<div class="container">
  <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('/admin')}}">หน้าแรก</a></li>
          <li class="breadcrumb-item active">เปลี่ยนรหัสผ่าน</li>
  </ol>
  <div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">{{ __('เปลี่ยนรหัสผ่าน') }}</div>
              <div class="card-body">
                  @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                  @endif
                  @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                  @endif
              <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
              <form class="form-horizontal" method="POST" action="{{ url('admin/changePassword') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                  <label for="new-password" class="col-md-12 control-label">รหัสผ่านเก่า
                    @if ($errors->has('current-password'))
  									<span class="text-danger">({{ $errors->first('current-password') }})</span>
  									@endif
                  </label>
                      <input id="current-password" type="password" class="form-control" name="current-password">

                </div>
                <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                  <label for="new-password" class="col-md-12 control-label">รหัสผ่านใหม่
                    @if ($errors->has('new-password'))
                    <span class="text-danger">({{ $errors->first('new-password') }})</span>
                    @endif
                  </label>

                      <input id="new-password" type="password" class="form-control" name="new-password" >

                </div>
                <div class="form-group">
                  <label for="new-password-confirm" class="col-md-12 control-label">ยืนยันรหัสผ่าน</label>

                      <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" >

                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                      เปลี่ยนรหัสผ่าน
                    </button>
                </div>
              </div>
              <div class="col-md-3"></div>
              </form>
            </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
