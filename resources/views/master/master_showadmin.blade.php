@extends('layouts.app')
@include('template/bg_top')
@section('content')
<div class="container">
  <ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" href="{{url('master/home')}}">ข้อมูลสมาชิกทั้งหมด</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{url('master/total')}}">รายการคะแนนเสียงทั้งหมด</a>
  </li>
</ul><br>
<div class="row">
      <div class="col-md-12">
          <div class="col-md-12 ">
              <div class="panel panel-info">
                  <div class="panel-heading">
                  <div class="row">
                    <div class="col col-xs-6">
                      <h3 class="panel-title">ตารางรายชื่อผู้ดูแลเขต</h3>
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
                              <th>ชื่อผู้ดูแลเขต</th>
                              <th>ตำบล</th>
                              <th>อำเภอ</th>
                              <th>จังหวัด</th>
                              <th>คะแนนเสียง</th>
                              <th width="10%"><center><i class="fa fa-cog"></i></center></th>
                            </tr>
                          </thead>
                          @if(isset($admins))
                          @foreach($admins as $index => $admin)
                          <tbody>
                            <tr>
                              <td></td>
                              <td class="hidden-xs">{{$NUM_PAGE*($page-1) + $index+1}}</td>
                              <td><p>{{$admin->admin_name}}</p></td>
                              <td>{{$header->district}}</td>
                              <td>{{$header->amphoe}}</td>
                              <td>{{$header->province}}</td>
                              <?php $sum = 0;
                                foreach ($admin->score_admin as $key => $value) {
                                  $sum = $sum + $value->score;
                                }
                              ?>

                              <td>{{ $sum }}</td>
                              <td>
                              <center>
                                <a href="{{url('master/showarea')}}/{{$admin->id}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> แสดงข้อมูลเขต</a>

                                {{csrf_field()}}
                              </center>
                              </td>
                            </tr>
                          </tbody>
                          @endforeach
                          @endif
                        </table><!--/.table-->
                      </div><!--/.table-responsive-->
                  </div><!--/.panel-body-->
                  <div class="panel-footer">
                  <div class="row">
                    <div class="col col-xs-4"></div>
                    <div class="col col-xs-8">
                      <ul class="pull-right">
                        {{ $admins->links() }}
                      </ul>
                    </div>
                  </div>
                </div>
              </div><!--/.panel-->
          </div>
    </div>
</div>
@endsection

@extends('template/footer')
