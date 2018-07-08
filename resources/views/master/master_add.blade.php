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
      <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css')}}">
  @include('template/bg_top')
</head>
<body>
    <div class="bg"></div>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
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
                                   <a class="dropdown-item" href="{{url('/profile')}}">
                                      แก้ไขโปรไฟล์
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
            </div>
        </nav>
    </div>
<form action="{{url('master/add')}}" method="post" enctype="multipart/form-data" id="demo1" class="demo" style="display:none;" autocomplete="off">
{{ csrf_field() }}
<div class="container">
  <br>
  <ol class="breadcrumb">
  				<li class="breadcrumb-item"><a href="{{url('/home')}}">หน้าแรก</a></li>
  				<li class="breadcrumb-item active">กรอกข้อมูลสมาชิกในพรรค</li>
  </ol>

  <div class="card" >
    <div class="card-header">
      กรอกข้อมูลสมาชิกในพรรค
      </div>
      <ul class="list-group list-group-flush">
      <div class="container">
    <div class="row">
        <div class="col-md-1"></div>
      <div class="col-md-5"><br>
          <div class="form-group">
            <label>ชื่อสมาชิก</label>
            <input class="form-control" name="header_name" type="text">
          </div>
          <p>
            <label>ชื่อเข้าใช้งานระบบ</label>
            <input class="form-control" name="name" type="text">
          </p>
          <p>
            <label>เบอร์โทรศัพท์</label>
            <input class="form-control" name="tel" type="text">
          </p>
          <p>
               <label>อำเภอ</label>
               <input class="form-control" name="amphoe" type="text" >
          </p>
					<p>
               <label>สถานะ</label>
							 <select class="form-control" name="status">
               <option>1</option>
							 <option>0</option>
						  </select>
          </p>
        </div>
      <div class="col-md-5"><br>
        <p>
            <label>อีเมลเข้าใช้งานระบบ</label>
            <input class="form-control" name="email" type="text">
          </p>
        <p>
            <label>รหัสผ่าน</label>
            <input class="form-control" name="password" type="password">
        </p>
        <p>
          <label>ตำบล</label>
          <input class="form-control" name="district" type="text" >
        </p>
        <p>
          <label>จังหวัด</label>
          <input class="form-control" name="province" type="text" >
        </p>

        <input type="hidden" class="form-control" name="master_id" value="{{Auth::user()->id}}">
        <input type="hidden" class="form-control" name="image" value="profile.jpg">
      </div>
        <div class="col-md-1"></div>
          </div>
          <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-5"><div align="right"><button type="submit" class="btn btn-info">Save</button><br><br></div></div>
            <div class="col-md-1"></div>
          </div>
    </div>
    </ul>
  </div>
</div>
</form>
<script type="text/javascript" src="{{asset('https://code.jquery.com/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.20/js/uikit.min.js"></script>
<script type="text/javascript" src="{{asset('jquery.Thailand.js/dependencies/zip.js/zip.js')}}"></script>
<script type="text/javascript" src="{{asset('jquery.Thailand.js/dependencies/JQL.min.js')}}"></script>
<script type="text/javascript" src="{{asset('jquery.Thailand.js/dependencies/typeahead.bundle.js')}}"></script>
<script type="text/javascript" src="{{asset('jquery.Thailand.js/dist/jquery.Thailand.min.js')}}"></script>

<script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o), m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-33058582-1', 'auto', {
            'name': 'Main'
        });
        ga('Main.send', 'event', 'jquery.Thailand.js', 'GitHub', 'Visit');
</script>

<script type="text/javascript">
        $.Thailand({
            database: '{{asset('jquery.Thailand.js/database/db.json')}}',
            $district: $('#demo1 [name="district"]'),
            $amphoe: $('#demo1 [name="amphoe"]'),
            $province: $('#demo1 [name="province"]'),
            $zipcode: $('#demo1 [name="zipcode"]'),
            onDataFill: function(data){
                console.info('Data Filled', data);
            },
            onLoad: function(){
                console.info('Autocomplete is ready!');
                $('#loader, .demo').toggle();
            }
        });
        $('#demo1 [name="district"]').change(function(){
            console.log('ตำบล', this.value);
        });
        $('#demo1 [name="amphoe"]').change(function(){
            console.log('อำเภอ', this.value);
        });
        $('#demo1 [name="province"]').change(function(){
            console.log('จังหวัด', this.value);
        });
        $('#demo1 [name="zipcode"]').change(function(){
            console.log('รหัสไปรษณีย์', this.value);
        });
</script>
</body>
</html>
