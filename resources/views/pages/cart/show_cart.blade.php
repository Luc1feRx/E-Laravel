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
    </div>
</section> <!--/#cart_items-->

<section id="do_action">
    <div class="container">
        <div class="heading">
            <h3>What would you like to do next?</h3>
            <p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="chose_area">
                    <ul class="user_option">
                        <li>
                            <input type="checkbox">
                            <label>Use Coupon Code</label>
                        </li>
                        <li>
                            <input type="checkbox">
                            <label>Use Gift Voucher</label>
                        </li>
                        <li>
                            <input type="checkbox">
                            <label>Estimate Shipping & Taxes</label>
                        </li>
                    </ul>
                    <ul class="user_info">
                        <li class="single_field">
                            <label>Country:</label>
                            <select>
                                <option>United States</option>
                                <option>Bangladesh</option>
                                <option>UK</option>
                                <option>India</option>
                                <option>Pakistan</option>
                                <option>Ucrane</option>
                                <option>Canada</option>
                                <option>Dubai</option>
                            </select>

                        </li>
                        <li class="single_field">
                            <label>Region / State:</label>
                            <select>
                                <option>Select</option>
                                <option>Dhaka</option>
                                <option>London</option>
                                <option>Dillih</option>
                                <option>Lahore</option>
                                <option>Alaska</option>
                                <option>Canada</option>
                                <option>Dubai</option>
                            </select>

                        </li>
                        <li class="single_field zip-field">
                            <label>Zip Code:</label>
                            <input type="text">
                        </li>
                    </ul>
                    <a class="btn btn-default update" href="">Get Quotes</a>
                    <a class="btn btn-default check_out" href="">Continue</a>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        <li>Tổng<span>{{Cart::priceTotal(0, ',', '.') . ' VND'}}</span></li>
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
        </div>
    </div>
</section><!--/#do_action-->

@endsection
