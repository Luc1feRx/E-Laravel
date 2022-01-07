@extends('admin_layout')
@section('admin_contents')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Danh Sách Sản Phẩm
      </div>
      <div class="row w3-res-tb">
        <div class="col-sm-5 m-b-xs">
          <select class="input-sm form-control w-sm inline v-middle">
            <option value="0">Bulk action</option>
            <option value="1">Delete selected</option>
            <option value="2">Bulk edit</option>
            <option value="3">Export</option>
          </select>
          <button class="btn btn-sm btn-default">Apply</button>
        </div>
        <div class="col-sm-4">
        </div>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" class="input-sm form-control" placeholder="Search">
            <span class="input-group-btn">
              <button class="btn btn-sm btn-default" type="button">Go!</button>
            </span>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        @php
        $message = Session::get('message');
        if($message){
            echo $message;
            Session::put('message', null);
        }
        @endphp
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th style="width:20px;">
                <label class="i-checks m-b-none">
                  <input type="checkbox"><i></i>
                </label>
              </th>
              <th>Tên Sản Phẩm</th>
              <th>Giá</th>
              <th>Hình Ảnh</th>
              <th>Danh Mục</th>
              <th>Thương Hiệu</th>
              <th>Hiển Thị</th>
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($listProduct as $item)
            <tr>
              <td><label class="i-checks m-b-none"><input type="checkbox"><i></i></label></td>
              <td>{{$item->product_name}}</td>
              <td>{{$item->product_price}}</td>
              <td><img src="public/upload/product/{{$item->product_image}}" alt="" height="100px" width="100px"></td>
              <td>{{$item->category_name}}</td>

              <td>{{$item->brand_name}}</td>
              <td><span class="text-ellipsis">

                @if ($item->product_status == 1)
                    <a href="{{route('unactived-status-product', $item->product_id)}}"><span><i style="font-size: 23px; color: green;" class="fa fa-thumbs-up"></i></span></a>
                @else
                    <a href="{{route('actived-status-product', $item->product_id)}}"><span><i style="font-size: 23px; color: red;" class="fa fa-thumbs-down"></i></span></a>
                @endif

              </span></td>
              <td>
                <a href="{{ route('editProduct', $item->product_id) }}" style="font-size: 20px;" class="active" ui-toggle-class="">

                    <i class="fa fa-pencil-square-o text-success text-active"></i>

                </a>

                <a href="{{route('deleteProduct', $item->product_id)}}" onclick="return confirm('Bạn Có Muốn Xóa Không?')" style="font-size: 20px;" class="active" ui-toggle-class="">

                    <i class="fa fa-times text-danger text"></i>

                </a>
              </td>
            </tr>

          </tbody>
          @endforeach
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
