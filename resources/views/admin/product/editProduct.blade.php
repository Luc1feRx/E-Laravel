@extends('admin_layout')
@section('admin_contents')
<div class="container">
    <div class="row">
                    <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Cập Nhật Sản Phẩm
                    </header>
                    <div class="panel-body">
                        @php
                        $message = Session::get('message');
                        if($message){
                            echo $message;
                            Session::put('message', null);
                        }
                        @endphp
                        <div class="position-center">
                            @foreach ($editProduct as $item)

                            <form role="form" action="{{route('updateProduct', $item->product_id)}}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name_category">Tên Sản Phẩm: </label>
                                <input type="text" class="form-control" name="product_name" id="name_category" value="{{$item->product_name}}">
                            </div>

                            <div class="form-group">
                                <label for="name_category">Giá Sản Phẩm: </label>
                                <input type="number" class="form-control" name="product_price" id="name_category" value="{{$item->product_price}}">
                            </div>

                            <div class="form-group">
                                <label>Hình Ảnh Sản Phẩm: </label>
                                <input type="file" class="form-control" name="product_image">
                                <img src="{{URL::to('public/upload/product/'.$item->product_image)}}" width="150px" height="150px"alt="" srcset="">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô Tả Sản Phẩm</label>
                                <textarea class="form-control" name="product_desc" type="text" id="exampleInputPassword1" style="resize: none" cols="30" rows="10">{{$item->product_desc}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Nội Dung Sản Phẩm</label>
                                <textarea class="form-control" name="product_content" type="text" id="exampleInputPassword1" style="resize: none" cols="30" rows="10">{{$item->product_content}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2">Danh Mục Sản Phẩm</label>
                                <select name="product_category" class="form-control m-bot15">
                                    @foreach ($cate_products as $cate_item)

                                        @if ($cate_item->category_id == $item->category_id)
                                            <option selected value="{{$cate_item->category_id}}">{{$cate_item->category_name}}</option>
                                        @else
                                            <option value="{{$cate_item->category_id}}">{{$cate_item->category_name}}</option>
                                        @endif

                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2">Thương Hiệu Sản Phẩm</label>
                                <select name="product_brand" class="form-control m-bot15">
                                    @foreach ($brand_products as $brand_item)

                                    @if ($brand_item->brand_id == $item->brand_id)
                                        <option selected value="{{$brand_item->brand_id}}">{{$brand_item->brand_name}}</option>
                                    @else
                                        <option value="{{$brand_item->brand_id}}">{{$brand_item->brand_name}}</option>
                                    @endif

                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" name="add_product" class="btn btn-info">Cập Nhật Sản Phẩm</button>
                        </form>
                        @endforeach
                        </div>

                    </div>
                </section>

        </div>
    </div>
</div>
@endsection
