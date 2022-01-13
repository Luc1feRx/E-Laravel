@extends('layout')
@section('contents')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{ route('home') }}">Trang Chủ</a></li>
              <li class="active">Giỏ Hàng Của Bạn</li>
            </ol>
        </div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @elseif (session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('message') }}
        </div>
        @endif
        <div class="table-responsive cart_info">
            <form action="{{ route('update-cart') }}" method="post">
                {{ csrf_field() }}
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình Ảnh</td>
                        <td class="description">Tên Sản Phẩm</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số Lượng</td>
                        <td class="total">Thành Tiền</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach (session()->get('cart') as $item)
                    @php
                        $subtotal = $item['product_price'] * $item['product_qty'];
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="{{ asset('public/upload/product/' . $item['product_image']) }}" width="70" alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$item['product_name']}}</a></h4>
                            <p>ID: {{$item['product_id']}}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($item['product_price'], 0, ',', '.') . ' VND'}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                    {{ csrf_field() }}
                                    <input class="cart_quantity_" type="number" min="1" name="quantity_cart[{{$item['session_id']}}]" value="{{$item['product_qty']}}">
                                    <input class="form-control" type="hidden" value="" name="RowId_cart">
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">
                                {{number_format($subtotal, 0, ',', '.') . ' VND'}}
                            </p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" onclick="return confirm('Bạn Có Muốn Xóa Không?')" href="{{ route('delete-cart-ajax', ['iddelete'=>$item['session_id']]) }}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>

                    @endforeach
                    <tr>
                        <td><input class="btn btn-default check_out" type="submit" value="Cập Nhật" name="update_qty"></td>
                    </tr>
                </tbody>
            </form>
            </table>

        </div>
    </div>
</section> <!--/#cart_items-->

<section id="do_action">
<div class="col-sm-6">
    <div class="total_area">
        <ul>
            <li>Tổng<span>{{number_format($total, 0, ',', '.') . ' VND'}}</span></li>
            <li>Thuế <span>{{Cart::tax(0, ',', '.') . ' VND'}}</span></li>
            <li>Phí Vận Chuyển <span>Free</span></li>
            <li>Thành Tiền<span>{{Cart::total(0, ',', '.') . ' VND'}}</span></li>
        </ul>
        <?php
        $customer_id = Session::get('customer_id');
        if ($customer_id != null) {
    ?>
    <a style="text-decoration: none; margin-right: 10px" href="{{ route('checkout') }}" class="btn btn-default check_out"> Thanh Toán</a>
    <?php
        } else {

    ?>
    <a style="text-decoration: none; margin-right: 10px" href="{{ route('login-checkout') }}" class="btn btn-default check_out"> Thanh Toán</a>
    <?php
        }
    ?>
    </div>
</div>
</section>

@endsection
