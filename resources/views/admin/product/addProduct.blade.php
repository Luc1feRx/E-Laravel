@extends('admin_layout')
@section('admin_contents')
<div class="container">
    <div class="row">
                    <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Thêm Sản Phẩm
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
                            <form role="form" action="{{route('SaveProduct')}}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name_category">Tên Sản Phẩm: </label>
                                <input type="text" data-validation="length" data-validation-length="min3" data-validation-error-msg="Làm Ơn Điền Ít Nhất 3 Ký Tự" class="form-control" name="product_name" id="name_category" placeholder="Nhập Tên Danh Mục">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="name_category">Giá Sản Phẩm: </label>
                                <input type="number" class="form-control" name="product_price" id="name_category" placeholder="Nhập Tên Danh Mục">
                            </div>

                            <div class="form-group">
                                <label>Hình Ảnh Sản Phẩm: </label>
                                <input type="file" class="form-control" name="product_image">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô Tả Sản Phẩm</label>
                                <textarea class="form-control" name="product_desc" type="text" id="ckeditor1" placeholder="Nhập Mô Tả Danh Mục" style="resize: none" cols="30" rows="10"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Nội Dung Sản Phẩm</label>
                                <textarea class="form-control" name="product_content" type="text" id="ckeditor" placeholder="Nhập Nội Dung Danh Mục" style="resize: none" cols="30" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2">Danh Mục Sản Phẩm</label>
                                <select name="product_category" class="form-control m-bot15">
                                    @foreach ($cate_products as $cate_item)
                                    <option value="{{$cate_item->category_id}}">{{$cate_item->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2">Thương Hiệu Sản Phẩm</label>
                                <select name="product_brand" class="form-control m-bot15">
                                    @foreach ($brand_products as $brand_item)
                                    <option value="{{$brand_item->brand_id}}">{{$brand_item->brand_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2">Hiển Thị</label>
                                <select name="product_status" class="form-control m-bot15">
                                    <option value="0">Ẩn</option>
                                    <option value="1">Hiển Thị</option>
                                </select>
                            </div>
                            <button type="submit" name="update_product" class="btn btn-info">Thêm Sản Phẩm</button>
                        </form>
                        </div>

                    </div>
                </section>

        </div>
    </div>
</div>
@endsection
