@extends('layouts.app')
@include('template/bg_top')
@section('content')
<div class="container">
  <ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" href="{{url('master/home')}}">ข้อมูลสมาชิกทั้งหมด</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{url('/master/total')}}">รายการคะแนนเสียงทั้งหมด</a>
  </li>
</ul><br>
<div class="row">
  <div class="col-sm-9">
    <div class="col-md-12 ">
            <div class="panel panel-info">
                <div class="panel-heading">
                <div class="row">
                  <div class="col col-xs-6">
                    <h3 class="panel-title">ตารางรายชื่อสมาชิก</h3>
                  </div>
                  <div class="col col-xs-6 text-right">
                    <a href = "{{url('/master/register')}}" class="btn btn-sm btn-primary btn-create">เพิ่มสมาชิก</a>
                  </div>
                </div>
                </div><!--/.panel-heading-->
                <div class="panel-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered table-list">
                        <thead>
                          <tr>
                            <th></th>
                            <th class="hidden-xs">#</th>
                            <th width="15%">ชื่อสมาชิก</th>
                            <th>ตำบล</th>
                            <th>อำเภอ</th>
                            <th>จังหวัด</th>
                            <th width="14%">หมายเหตุ</th>
                            <th width="27%"><center><i class="fa fa-cog"></i></center></th>
                          </tr>
                        </thead>
                        @foreach($headers as $index => $header)
                        <tbody>
                          <tr>
                            <td width="7%"><img class="img-rounded img-responsive center-block" src="{{url('uploads')}}/{{$header->image}}" width="100%"></td>
                            <td class="hidden-xs">{{$NUM_PAGE*($page-1) + $index+1}}</td>
                            <td>
                              @if($header->status == "1")
                               <font color="green"> &#9679; </font>{{$header->header_name}}
                              @else
                               <font color="red"> &#9679; </font>{{$header->header_name}}
                              @endif
                            </td>
                            <td>{{$header->district}}</td>
                            <td>{{$header->amphoe}}</td>
                            <td>{{$header->province}}</td>
                            <td>sdfasefsfsf<br>sdfgdsgdfg</td>
                        
                            <td>

                              <a href="{{url('master/show/')}}/{{$header->id}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> แสดง</a>
                              <a href="{{url('master/edit/')}}/{{$header->id}}" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> แก้ไข</a>
                              <form  action="{{url('master/block')}}/{{$header->id}}" onsubmit="return myFunction();return false;" method="post">
                              <input type="hidden" name="note" id="myText">
                              @if($header->status == "1")
                              {{csrf_field()}}
                              <input type="submit" value="Submit" class="btn btn-success btn-sm">
                             </form>
                              @else
                              <a href="{{url('master/block')}}/{{$header->id}}" class="btn btn-danger btn-sm" onclick="return confirm('ท่านต้องการปลดบล็อกสมาชิกใช่หรือไม่ ?')"><i class="fa fa-trash"></i>ปลดบล็อก</a>
                              @endif
                              {{csrf_field()}}
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
                      {{ $headers->links() }}
                    </ul>
                  </div>
                </div>
              </div>
            </div><!--/.panel-->
  </div>
</div>
  <div class="col-sm-3">
  <div class="card">
    <form action="{{url('master/home')}}" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
    <h6 class="card-header">ค้นหาสมาชิก</h6>
      <div class="card-body">
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">ชื่อ</label>
          <div class="col-sm-8">
              <input type="text" class="form-control" name="key" autocomplete="off">
            </select>
          </div>
      </div>
      <div class="form-group row mb-0">
      <div class="col-sm-12">
					<input type="submit" class="btn btn-block btn-primary" value="ค้นหา">
				</div>
      </div>
      </div>
    </form>
  </div>
  </div>
</div>
@endsection
<script>
function myFunction() {
    var txt;
    var person = prompt("กรอกหมายเหตุ:", "");
    if (person == null || person == "") {
        txt = "";
    } else {
        txt = " " + person + "";
    }

    document.getElementById("myText").value = txt;
}
</script>
@extends('template/footer')
