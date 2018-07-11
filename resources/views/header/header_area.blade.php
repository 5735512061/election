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
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css')}}">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="{{asset('jquery.Thailand.js/dist/jquery.Thailand.min.css')}}">
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <title>ระบบเก็บคะแนนเสียงเลือกตั้ง</title>
</head>
<body>
  <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
      <div class="container">
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
                             <a class="dropdown-item" href="{{url('/header/profile')}}">
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
  <br>
<form action="{{url('header/addarea')}}"  id="demo1" class="demo" style="display:none;" autocomplete="off">
{{ csrf_field() }}
<div class="container">
  <ol class="breadcrumb">
  				<li class="breadcrumb-item"><a href="{{url('/header')}}">หน้าแรก</a></li>
          <li class="breadcrumb-item"><a href="{{url('/header/total')}}">รายการคะแนนเสียงทั้งหมด</a></li>
  				<li class="breadcrumb-item active">กรอกข้อมูลเขตการดูแล</li>
  </ol>
  <div class="card">
    <div class="card-header">
      กรอกข้อมูลเขตเลือกตั้ง
    </div>
      <ul class="list-group list-group-flush">
      <div class="container">
        <br>
        <div class="row">
          <div class="col-md-1"></div>
            <div class="col-md-5">
              <div class="form-group">
                <label>ชื่อผู้ดูแลเขต</label>
                      @if (isset($admin_name))
                       <input class="form-control" value="{{$admin_name}}" type="text" disabled>
                      @endif
                      @if ($errors->has('admin_id'))
                      <span class="text-danger">({{ $errors->first('admin_id') }})</span>
                      @endif
                      @if (isset($alladmins))
                      <select name="admin_id" id="admin_id" class="form-control">
                      <option disabled selected value=""></option>
                      @foreach($alladmins as $alladmin)
                        <option value="{{$alladmin->id}}">
                          {{$alladmin->name}}
                        </option>
                      @endforeach
                      </select>
                      @endif
              </div>
              <p>
                <label>ตำบล</label>
                <input class="form-control" name="district" value="{{$header->district}}" type="text" disabled>
              </p>
              <p>
                <label>จังหวัด</label>
                <input class="form-control" name="province" value="{{$header->province}}" type="text" disabled>
              </p>
          </div>
          <div class="col-md-5">
              <!-- <p>
                  <label>เขตเลือกตั้ง</label>
                  <input class="form-control" name="area_name" type="text">
              </p> -->
              <label>เขตเลือกตั้ง
                @if ($errors->has('area_name.*'))
  							<span class="text-danger">({{ $errors->first('area_name.*') }})</span>
  							@endif
              </label>
              <div class="contacts">
                <div class="form-group multiple-form-group input-group">
                  <input type="text" name="area_name[]" class="form-control">
                    <span class="input-group-btn">
                      <button type="button"  class="btn btn-success btn-add">+</button>
                    </span>
                </div>
              </div>
              <p>
                <label>อำเภอ</label>
                <input class="form-control" name="amphoe" value="{{$header->amphoe}}" type="text" disabled>
              </p>
        </div>
        <div class="col-md-1"></div>
      </div>
          <div class="row">
            <div class="col-md-6"></div>
            @if (isset($admin_id))
            <input type="hidden" value="{{$admin_id}}" name="admin_id">
            @endif

            <div class="col-md-5"><div align="right"><button type="submit" class="btn btn-info">บันทึกข้อมูล</button><br><br></div></div>
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

<script>
  (function ($) {
    $(function () {

        var addFormGroup = function (event) {
            event.preventDefault();

            var $formGroup = $(this).closest('.form-group');
            var $multipleFormGroup = $formGroup.closest('.multiple-form-group');
            var $formGroupClone = $formGroup.clone();

            $(this)
                .toggleClass('btn-success btn-add btn-danger btn-remove')
                .html('–');

            $formGroupClone.find('input').val('');
            $formGroupClone.find('.concept').text('Phone');
            $formGroupClone.insertAfter($formGroup);

            var $lastFormGroupLast = $multipleFormGroup.find('.form-group:last');
            if ($multipleFormGroup.data('max') <= countFormGroup($multipleFormGroup)) {
                $lastFormGroupLast.find('.btn-add').attr('disabled', true);
            }
        };

        var removeFormGroup = function (event) {
            event.preventDefault();

            var $formGroup = $(this).closest('.form-group');
            var $multipleFormGroup = $formGroup.closest('.multiple-form-group');

            var $lastFormGroupLast = $multipleFormGroup.find('.form-group:last');
            if ($multipleFormGroup.data('max') >= countFormGroup($multipleFormGroup)) {
                $lastFormGroupLast.find('.btn-add').attr('disabled', false);
            }

            $formGroup.remove();
        };

        var selectFormGroup = function (event) {
            event.preventDefault();

            var $selectGroup = $(this).closest('.input-group-select');
            var param = $(this).attr("href").replace("#","");
            var concept = $(this).text();

            $selectGroup.find('.concept').text(concept);
            $selectGroup.find('.input-group-select-val').val(param);

        }

        var countFormGroup = function ($form) {
            return $form.find('.form-group').length;
        };

        $(document).on('click', '.btn-add', addFormGroup);
        $(document).on('click', '.btn-remove', removeFormGroup);
        $(document).on('click', '.dropdown-menu a', selectFormGroup);

    });
})(jQuery);
</script>
</body>
</html>
