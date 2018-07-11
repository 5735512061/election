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
                          @foreach($scores as $row)
                              @if($row->area_id==$area->id)
                                <td>{{$row->score}}</td>
                              @break
                              @elseif($loop->last)
                          <td></td>
                          @endif
                          @endforeach
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
@endsection

@extends('template/footer')
