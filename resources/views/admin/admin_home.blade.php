@extends('layouts.app_admin')
@section('content')
<div class="container">
  <ol class="breadcrumb">
        <h7>ผู้ดูแลเขต</h7>
  </ol>
  <ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" href="{{url('admin')}}">ข้อมูลเขตที่รับผิดชอบทั้งหมด</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{url('admin/showscore')}}">รายการคะแนนเสียงทั้งหมด</a>
  </li>
</ul><br>
<div class="row">
  <div class="col-md-9">
  @if(isset($allareas))
  <form action="{{url('admin/addscore')}}" method="POST" autocomplete="off">
  {{ csrf_field() }}
  <div class="row">
    <div class="col-md-5">
       เขตเลือกตั้ง
       @if ($errors->has('area_id'))
        <span class="text-danger">({{ $errors->first('area_id') }})</span>
       @endif
    </div>
    <div class="col-md-4">
       วันที่เก็บคะแนน
       @if ($errors->has('date'))
        <span class="text-danger">({{ $errors->first('date') }})</span>
       @endif
    </div>
    <div class="col-md-2"></div>
  </div>
  <div class="row">
    <div class="col-md-5">
       <select name="area_id" id="area_id" class="form-control" required>
              <option disabled selected value="">เลือกเขตที่ต้องการจะกรอกคะแนน</option>
              @foreach($allareas as $allarea)
                  <option value="{{$allarea->id}}">{{ $allarea->area_name }}</option>
              @endforeach
       </select>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <input class="form-control" name="date" type="date" required>
      </div>
    </div>
    <div class="col-md-1">
      <button type="submit" class="btn btn-success">กรอกคะแนน</button>
    </div>
  </div>
  </form>
  @endif
  @if(isset($areas))
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
                        </tr>
                      </thead>
                      @foreach($areas as $index => $area)
                      <tbody>
                        <tr>
                          <td class="hidden-xs">{{$NUM_PAGE*($page-1) + $index+1}}</td>
                          <td>{{$area->area_name}}</td>
                          <td>{{$header->district}}</td>
                          <td>{{$header->amphoe}}</td>
                          <td>{{$header->province}}</td>
                          @if(isset($query))
                          @foreach($query as $q)
                          @if($q->area_name==$area->area_name)
                          <td>{{$q->sumscore}}</td>
                          @break
                          @elseif($loop->last)
                          <td></td>
                          @endif
                          @endforeach
                          @endif
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
@endif
@if(isset($admin_add))
<form action="{{url('admin/addscore')}}" method="POST" >
{{ csrf_field() }}
<div class="row">
  <div class="col-md-5">
     เขตเลือกตั้ง
  </div>
  <div class="col-md-4">
     วันที่เก็บคะแนน
  </div>
  <div class="col-md-2"></div>
</div>
<div class="row">
  <div class="col-md-5">
     <select name="area_id" id="area_id" class="form-control" required>
            <option disabled selected value="">เลือกเขตที่ต้องการจะกรอกคะแนน</option>
            @foreach($allareas_add as $allarea)
                <option value="{{$allarea->id}}" required>{{ $allarea->area_name }}</option>
            @endforeach
     </select>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <input class="form-control" name="date" type="date" required>
    </div>
  </div>
  <div class="col-md-1">
    <button type="submit" class="btn btn-success">กรอกคะแนน</button>
  </div>
</div>
</form>
<form action="{{url('admin/scoresubmit')}}" method="POST">
  {{ csrf_field() }}
  	<div class="card" >
  		<div class="card-header">
      	กรอกข้อมูลคะแนนเลือกตั้ง
    		</div>
    		<ul class="list-group list-group-flush">
    		<div class="container">
  		<div class="row">
  		    <div class="col-md-1"></div>
  			<div class="col-md-5">
            <p>
              <label>ชื่อหัวหน้าพรรค</label>
              <input class="form-control" name="master_name" type="text" value="{{$master_add->master_name}}" disabled>
            </p>
            <p>
              <label>ตำบล</label>
              <input class="form-control" name="district" type="text" value="{{$header_add->district}}" disabled>
            </p>
            <p>
              <label>จังหวัด</label>
              <input class="form-control" name="province" value="{{$header_add->province}}" type="text" disabled>
            </p>
  			    <p>
              <label>คะแนนเสียง

              </label>
              <input class="form-control" type="number" value="{{old ('score')}}" min="0" name="score" required>
            </p>
    			</div>
  			<div class="col-md-5">
  				  <p>
              <label>ชื่อสมาชิก</label>
              <input class="form-control" name="header_name" type="text" value="Header1" disabled>
            </p>
            <p>
              <label>อำเภอ</label>
              <input class="form-control" name="amphoe" value="{{$header_add->amphoe}}" type="text" disabled>
            </p>
            <div class="form-group">
              <p>
                <label>เขตการเลือกตั้ง</label>
                <input class="form-control" value="{{$area_add->area_name}}" type="text" disabled>
              </p>
            </div>
  					<p>
             <label>วันที่เก็บคะแนน</label>
              <input class="form-control" name="date" type="date" value="{{$date}}" required>
            </p>

  			</div>
  		    <div class="col-md-1"></div>
            </div>
            <div class="row">
              <div class="col-md-6"></div>
              <input type="hidden" class="form-control" name="header_id" value="{{$header_add->id}}">
  						<input type="hidden" class="form-control" name="master_id" value="{{$master_add->id}}">
              <input type="hidden" class="form-control" name="area_id" value="{{$area_add->id}}">
  		        <input type="hidden" class="form-control" name="admin_id" value="{{Auth::user()->id}}">
              <div class="col-md-5"><div align="right"><button type="submit" class="btn btn-info">บันทึกข้อมูล</button><br><br></div></div>
              <div class="col-md-1"></div>
            </div>
  		</div>
  		</ul>
  	</div>

</form>
@elseif(isset($score))
        <br>
        <form action="{{url('/admin/action')}}" method="POST" role="form">
                <div align="right">
                  <!-- admin -->
                  <button type="submit" name="update" value="update" id="update{{$score->score_id}}" class="btn btn-info btn-md" disabled="disabled"><span class="glyphicon glyphicon-edit"></span> อัพเดทคะแนน</button>
            			<button type="submit" name="delete" value="delete" id="delete{{$score->score_id}}" class="btn btn-danger btn-md" disabled="disabled" onclick="return confirm('ท่านต้องการลบคะแนนเขตนี้ใช่หรือไม่')">
                  ลบคะแนน</button>
                  {{csrf_field()}}
                </div>
                <br>
                  <div class="panel panel-info">
                      <div class="panel-body">
                          <div class="table-responsive">
                            <table class="table table-striped table-bordered table-list">
                              <thead>
                                <tr>
                                  <th><input type="checkbox" id="all" class="parent" data-group=".group"></th>
                                  <th class="hidden-xs">#</th>
                                  <th>ชื่อเขต</th>
                                  <th>ตำบล</th>
                                  <th>อำเภอ</th>
                                  <th>จังหวัด</th>
                                  <th width="15%">คะแนนเสียง</th>
                                  <th>วันเลือกตั้ง</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <input type="hidden" name="{{$score->score_id}}">
                                    <input type="checkbox" class="group" id="{{$score->score_id}}" name="checkbox[]" value="{{$score->score_id}}">
                                  </td>
                                  <td class="hidden-xs">1</td>
                                  <td>{{$area_search->area_name }}</td>
                                  <td>{{$header->district}}</td>
                                  <td>{{$header->amphoe}}</td>
                                  <td>{{$header->province}}</td>
                                  <td>
                                    <input class="form-control" name="score[]" id="score{{$score->score_id}}" type="number" value="{{$score->score}}" disabled="disabled" required min="0"></td>

                                  <td>{{$score->date}}</td>

                                </tr>
                              </tbody>

                            </table><!--/.table-->
                          </div><!--/.table-responsive-->
                      </div><!--/.panel-body-->
                      <div class="panel-footer">
                      <div class="row">
                        <div class="col col-xs-4"></div>
                        <div class="col col-xs-8">
                          <ul class="pull-right">
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div><!--/.panel-->

            </form>
@endif
</div>
<div class="col-sm-3">
<div class="card">
  <form action="{{url('/admin')}}" method="post" enctype="multipart/form-data">
      {{csrf_field()}}
  <h6 class="card-header">ค้นหาเขตรับผิดชอบ</h6>
    <div class="card-body">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">ชื่อเขต</label>
        <div class="col-sm-8">
              <input type="text" class="form-control" name="key" autocomplete="off">
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


<script type="text/javascript">
  	$(".parent").click(function(index){
  	var group = $(this).data("group");
  	var parent = $(this);
  	parent = parent.change();
  	parent.change(function(){  //"select all" change
  		 $(group).prop('checked', parent.prop("click"));
  	});
  });

  $('input').on("click", function(e){
  	var idcheck = e.target.id;
  		if(this.checked){
  			$('#score'+idcheck).removeAttr("disabled");
        $('#update'+idcheck).removeAttr("disabled");
        $('#delete'+idcheck).removeAttr("disabled");

  		}
  		else{
  			$('#score'+idcheck).attr("disabled", true);
      	$('#update'+idcheck).attr("disabled", true);
        $('#delete'+idcheck).attr("disabled", true);

  		}
  });

</script>
@endsection

@extends('template/footer')
