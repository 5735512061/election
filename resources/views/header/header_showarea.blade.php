<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.20/css/uikit.css">
  <link rel="stylesheet" href="{{asset('jquery.Thailand.js/dist/jquery.Thailand.min.css')}}">
  <link href="css/show_member.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css')}}">
</head>
<body>
<div class="container">
	<nav class="navbar navbar-expand-md navbar-light navbar-laravel">

					<a class="navbar-brand" href="{{ url('/header') }}">
							เก็บคะแนนเสียงเลือกตั้ง
					</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
							<span class="navbar-toggler-icon"></span>
					</button>

					<div class="collapse navbar-collapse" id="navbarSupportedContent">
							<!-- Left Side Of Navbar -->
							<ul class="navbar-nav mr-auto">

							</ul>

							<!-- Right Side Of Navbar -->
							<ul class="navbar-nav ml-auto">
									<!-- Authentication Links -->
									@guest
											<li class="nav-item">
													<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
											</li>
											<li class="nav-item">
													<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
											</li>
									@else
											<li class="nav-item dropdown">
													<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
															{{ Auth::user()->name }} <span class="caret"></span>
													</a>

													<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
														 <a class="dropdown-item" href="{{url('header/profile')}}">
																แก้ไขโปรไฟล์
														 </a>
														 <a class="dropdown-item" href="{{url('/header/changePassword')}}">
                                เปลี่ยนรหัสผ่าน
                             </a>
															<a class="dropdown-item" href="{{ route('logout') }}"
																 onclick="event.preventDefault();
																							 document.getElementById('logout-form').submit();">
																	{{ __('ออกจากระบบ') }}
															</a>

															<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
																	@csrf
															</form>
													</div>
											</li>
									@endguest
							</ul>
					</div>
	</nav>
	<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url('/header')}}">หน้าแรก</a></li>
					<li class="breadcrumb-item active">เพิ่มผู้ดูแลเขต</li>
	</ol>
  <div class="row">
    <div class="col-md-3">
        <div class="card">
					<div class="card-header">โปรไฟล์</div>
			      <ul class="list-group list-group-flush">
							<div class="container">
				    <div class="row">
				      <div class="col-md-1"></div>
				      <div class="col-md-10">
							<br>
			        <center>
			        <img src="{{url('uploads')}}/{{$admin->image}}" style="width:150px; height:150px;  border-radius:50%; margin-right:25px;">
							</center>

						</div>
						<div class="col-md-1"></div>
			      </div><br>
						
			    </ul>
        </div>
    </div>
    <div class="col-md-9">
            <div class="panel panel-info">
                <div class="panel-heading">
                <div class="row">
                  <div class="col col-xs-6">
                    <h3 class="panel-title">ตารางเขตรับผิดชอบของผู้ดูแลเขต</h3>
                  </div>
                </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered table-list">
                        <thead>
                          <tr>
                            <th class="hidden-xs">#</th>
                            <th>ชื่อเขต</th>
                            <th>ตำบล</th>
                            <th>อำเภอ</th>
                            <th>จังหวัด</th>
                            <th>คะแนนเสียง</th>
                            <th width="20%"><center><i class="fa fa-cog"></i></center></th>
                          </tr>
                        </thead>
                        @foreach($areas as $index => $area)
                        <tbody>
                          <tr>
                            <td class="hidden-xs">{{$NUM_PAGE*($page-1) + $index+1}}</td>
                            <td>{{$area->area_name}}</td>
                            <td>{{Auth::user()->district}}</td>
                            <td>{{Auth::user()->amphoe}}</td>
                            <td>{{Auth::user()->province}}</td>
														@foreach($scores as $row)
														@if($row->area_id == $area->id)
                            <td>{{$row->score}}</td>
														@break
	                          @elseif($loop->last)
	                          <td></td>
	                          @endif
														@endforeach
                            <td>
                            <center>

                              <a href="{{url('/header/editarea')}}/{{$area->id}}" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> แก้ไข</a>
                              <input type="hidden" name="_method" value="Delete">
                              <a href="{{url('/header/delete')}}/{{$area->id}}" class="btn btn-danger btn-sm" onclick="return confirm('ท่านต้องการลบเขตรับผิดชอบใช่หรือไม่ ?')"><i class="fa fa-trash"></i> ลบ</a>
                              {{csrf_field()}}
                            </center>
                            </td>
                          </tr>
                        </tbody>
                        @endforeach
                      </table><!--/.table-->
                    </div><!--/.table-responsive-->
                </div><!--/.panel-body-->
                <div class="panel-footer">
                <div class="row">
                  <div class="col col-xs-4"></div>
                  <div class="col col-xs-8">
                    <ul class="pull-right">
                      {{ $areas->links() }}
                    </ul>
                  </div>
                </div>
              </div>
        </div>
  </div>
  </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>




</body>
</html>
