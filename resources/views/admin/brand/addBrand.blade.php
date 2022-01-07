@extends('admin_layout')
@section('admin_contents')
<div class="container">
    <div class="row">
                    <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Thêm Thương Hiệu Sản Phẩm
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
                            <form role="form" action="{{route('SaveBrandProduct')}}" method="post">
                                {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name_category">Tên Thương Hiệu: </label>
                                <input type="text" class="form-control" name="name_brand_product" id="name_category" placeholder="Nhập Tên Danh Mục">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô Tả Thương Hiệu</label>
                                <textarea class="form-control" name="des_brand_product" type="text" id="exampleInputPassword1" placeholder="Nhập Mô Tả Danh Mục" style="resize: none" cols="30" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2">Hiển Thị</label>
                                <select name="status_brand_product" class="form-control m-bot15">
                                    <option value="0">Ẩn</option>
                                    <option value="1">Hiển Thị</option>
                                </select>
                            </div>
                            <button type="submit" name="add_brand_product" class="btn btn-info">Thêm Thương Hiệu</button>
                        </form>
                        </div>

                    </div>
                </section>

        </div>
    </div>
</div>
@endsection
