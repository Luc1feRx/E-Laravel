@extends('admin_layout')
@section('admin_contents')
<div class="container">
    <div class="row">
                    <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Cập Nhật Danh Mục Sản Phẩm
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
                            @foreach ($editCategory as $item)

                            <form role="form" action="{{ route('updateCategoryProduct', $item->category_id) }}" method="post">
                                {{ csrf_field() }}

                                <input type="hidden" value="{{$item->category_id}}" class="form-control" name="id_category_product">
                            <div class="form-group">
                                <label for="name_category">Tên Danh Mục: </label>
                                <input type="text" value="{{$item->category_name}}" class="form-control" name="name_category_product" id="name_category" placeholder="Nhập Tên Danh Mục">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô Tả Danh Mục</label>
                                <textarea class="form-control" name="des_category_product" type="text" id="exampleInputPassword1" placeholder="Nhập Mô Tả Danh Mục" style="resize: none" cols="30" rows="10">{{$item->category_desc}}</textarea>
                            </div>
                            <button type="submit" name="update_category_product" class="btn btn-info">Sửa Danh Mục</button>
                        </form>

                            @endforeach
                        </div>

                    </div>
                </section>

        </div>
    </div>
</div>
@endsection
