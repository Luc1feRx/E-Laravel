@extends('admin_layout')
@section('admin_contents')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Thông Tin Khách Hàng
      </div>
      <div class="table-responsive">
        {{-- @php
        $message = Session::get('message');
        if($message){
            echo $message;
            Session::put('message', null);
        }
        @endphp --}}
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th>Tên Khách Hàng</th>
              <th>Địa Chỉ</th>
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            <tr>
            @foreach ($Order_by_id as $order_by_id)
              <td>{{$order_by_id->customer_name}}</td>
              <td>{{$order_by_id->customer_phone}}</td>
            @endforeach
            </tr>
          </tbody>
        </table>
      </div>
      <footer class="panel-footer">
        <div class="row">

          <div class="col-sm-5 text-center">
            <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
          </div>
          <div class="col-sm-7 text-right text-center-xs">
            <ul class="pagination pagination-sm m-t-none m-b-none">
              <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
              <li><a href="">1</a></li>
              <li><a href="">2</a></li>
              <li><a href="">3</a></li>
              <li><a href="">4</a></li>
              <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </div>
<br><br>
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Thông Tin Vận Chuyển
      </div>
      <div class="table-responsive">
        {{-- @php
        $message = Session::get('message');
        if($message){
            echo $message;
            Session::put('message', null);
        }
        @endphp --}}
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th>Tên Người Vận</th>
              <th>Địa Chỉ</th>
              <th>Số Điện Thoại</th>
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            <tr>
            @foreach ($Order_by_id as $item)
              <td>{{$item->shipping_name}}</td>
              <td>{{$item->shipping_address}}</td>
              <td>{{$item->shipping_phone}}</td>
            @endforeach
            </tr>
          </tbody>
        </table>
      </div>
      <footer class="panel-footer">
        <div class="row">

          <div class="col-sm-5 text-center">
            <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
          </div>
          <div class="col-sm-7 text-right text-center-xs">
            <ul class="pagination pagination-sm m-t-none m-b-none">
              <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
              <li><a href="">1</a></li>
              <li><a href="">2</a></li>
              <li><a href="">3</a></li>
              <li><a href="">4</a></li>
              <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </div>
<br><br>
  <div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Danh Sách Chi Tiết Đơn Hàng
      </div>
      <div class="table-responsive">
        {{-- @php
        $message = Session::get('message');
        if($message){
            echo $message;
            Session::put('message', null);
        }
        @endphp --}}
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th>Tên Sản Phẩm</th>
              <th>Số Lượng</th>
              <th>Giá</th>
              <th>Tổng Tiền</th>
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($Order_by_id as $item1)
            <tr>
              <td>{{$item1->product_name}}</td>
              <td>{{$item1->product_sale_quantity}}</td>
              <td>{{$item1->product_price}}</td>
              <td>{{$item1->product_price * $item1->product_sale_quantity}}</td>
              <td>
                <a href="" style="font-size: 20px;" class="active" ui-toggle-class="">

                    <i class="fa fa-pencil-square-o text-success text-active"></i>

                </a>

                <a href="" onclick="return confirm('Bạn Có Muốn Xóa Không?')" style="font-size: 20px;" class="active" ui-toggle-class="">

                    <i class="fa fa-times text-danger text"></i>

                </a>
              </td>
            </tr>
            @endforeach

          </tbody>
        </table>
      </div>
      <footer class="panel-footer">
        <div class="row">

          <div class="col-sm-5 text-center">
            <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
          </div>
          <div class="col-sm-7 text-right text-center-xs">
            <ul class="pagination pagination-sm m-t-none m-b-none">
              <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
              <li><a href="">1</a></li>
              <li><a href="">2</a></li>
              <li><a href="">3</a></li>
              <li><a href="">4</a></li>
              <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </div>
@endsection
