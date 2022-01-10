@extends('admin_layout')
@section('admin_contents')
<div class="container">
    <div class="row">
                    <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Cập Nhật Thương Hiệu Sản Phẩm
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
                            <form role="form" action="{{ route('updateBrandProduct', $editbrand->brand_id) }}" method="post">
                                {{ csrf_field() }}

                                <input type="hidden" value="{{$editbrand->brand_id}}" class="form-control" name="id_brand_product">
                            <div class="form-group">
                                <label for="name_brand">Tên Thương Hiệu: </label>
                                <input type="text" value="{{$editbrand->brand_name}}" class="form-control" name="name_brand_product" id="name_brand" placeholder="Nhập Tên Danh Mục">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô Tả Thương Hiệu</label>
                                <textarea class="form-control" name="des_brand_product" type="text" id="exampleInputPassword1" placeholder="Nhập Mô Tả Danh Mục" style="resize: none" cols="30" rows="10">{{$editbrand->brand_desc}}</textarea>
                            </div>
                            <button type="submit" name="update_brand_product" class="btn btn-info">Sửa Thương Hiệu</button>
                        </form>
                        </div>

                    </div>
                </section>

        </div>
    </div>
</div>
@endsection
