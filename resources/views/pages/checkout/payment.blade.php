@extends('layout')
@section('contents')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{ route('home') }}">Trang Chủ</a></li>
              <li class="active">Thanh Toán Giỏ Hàng</li>
            </ol>
        </div><!--/breadcrums-->

        <div class="review-payment">
            <h2>Xem Lại Đơn Hàng</h2>
        </div>

        <div class="table-responsive cart_info">
            @php
                $content = Cart::content();
            @endphp
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Sản Phẩm</td>
                        <td class="description">Mô Tả</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số Lượng</td>
                        <td class="total">Tổng Tiền</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($content as $item_content)
                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="{{ asset('public/upload/product/' . $item_content->options->image) }}" width="70" alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$item_content->name}}</a></h4>
                            <p>ID: {{$item_content->id}}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($item_content->price) . ' VND'}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <form action="{{ route('update-cart-qty') }}" method="post">
                                    {{ csrf_field() }}
                                    <input class="cart_quantity_input" type="text" name="quantity_cart" value="{{$item_content->qty}}">
                                    <input class="form-control" type="hidden" value="{{$item_content->rowId}}" name="RowId_cart">
                                    <input class="btn btn-default btn-sm" type="submit" value="Cập Nhật" name="update_qty">
                                </form>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">

                                @php
                                    $subtotal = $item_content->price * $item_content->qty;
                                    echo number_format($subtotal,0,',', '.') . ' VND'
                                @endphp

                            </p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" onclick="return confirm('Bạn Có Muốn Xóa Không?')" href="{{ route('delete-cart', ['IdDelete'=>$item_content->rowId]) }}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <h4 style="margin: 40px 0; "></h4>

        <div class="payment-options">
            <form action="{{ route('order-place') }}" method="post">
                {{ csrf_field() }}
                <span>
                    <label><input name="payment_options" value="1" type="checkbox"> Trả Bằng ATM</label>
                </span>
                <span>
                    <label><input name="payment_options" value="2" type="checkbox"> Nhận Tiền Mặt</label>
                </span>
                <span>
                    <label><input name="payment_options" value="3" type="checkbox"> Thanh Toán Thẻ Ghi Nợ</label>
                </span>
                <input class="btn btn-primary btn-sm" type="submit" value="Đặt Hàng" name="send_order_place">
            </form>
            </div>
    </div>
</section> <!--/#cart_items-->

@endsection
