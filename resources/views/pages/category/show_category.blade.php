@extends('layout')
@section('contents')
<div class="features_items"><!--features_items-->
    @foreach ($category_by_name as $cateName)
    <h2 class="title text-center">{{$cateName->category_name}}</h2>
    @endforeach
    @foreach ($category_by_id as $product)
    <a href="{{ route('ProductDetail', ['product_id'=>$product->product_id, 'slug_product_detail'=>Str::slug($product->product_name)]) }}"></a>
    <div class="col-sm-4">
        <div class="product-image-wrapper">
            <div class="single-products">
                    <div class="productinfo text-center">
                        <img src="{{ asset('public/upload/product/' . $product->product_image) }}" alt="" />
                        <h2>{{number_format($product->product_price). ' VND'}}</h2>
                        <p>{{$product->product_name}}</p>
                        <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm Vào Giỏ Hàng</a>
                    </div>
            </div>
            <div class="choose">
                <ul class="nav nav-pills nav-justified">
                    <li><a href="#"><i class="fa fa-plus-square"></i>Yêu Thích</a></li>
                    <li><a href="#"><i class="fa fa-plus-square"></i>So Sách Sản Phẩm</a></li>
                </ul>
            </div>
        </div>
    </div>
    @endforeach
</div><!--features_items-->

@endsection

