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

        <div class="step-one">
            <h2 class="heading">Step1</h2>
        </div>
        <div class="checkout-options">
            <h3>New User</h3>
            <p>Checkout options</p>
            <ul class="nav">
                <li>
                    <label><input type="checkbox"> Register Account</label>
                </li>
                <li>
                    <label><input type="checkbox"> Guest Checkout</label>
                </li>
                <li>
                    <a href=""><i class="fa fa-times"></i>Cancel</a>
                </li>
            </ul>
        </div><!--/checkout-options-->

        <div class="register-req">
            <p>Please use Register And Checkout to easily get access to your order history, or use Checkout as Guest</p>
        </div><!--/register-req-->

        <div class="shopper-informations">
            <div class="row">
                <div class="col-sm-5 clearfix">
                    <div class="bill-to">
                        <p>Điền Thông Tin Gửi Hàng</p>
                        <div class="form-one">
                            <form method="post" action="{{ route('save-checkout-customer') }}">
                                {{ csrf_field() }}
                                <input type="email" name="shipping_email" placeholder="Email*">
                                <input type="text" name="shipping_name" placeholder="Họ Và Tên *">
                                <input type="text" name="shipping_address" placeholder="Địa Chỉ *">
                                <input type="number" name="shipping_phone" placeholder="Số Điện Thoại *">
                                <input class="btn btn-primary btn-sm" type="submit" value="Gửi" name="send_over">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="order-message">
                        <p>Ghi Chú Gửi Hàng</p>
                        <textarea name="message"  placeholder="Ghi Chú Đơn Hàng Của bạn" rows="16"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="review-payment">
            <h2>Xem Lại Đơn Hàng</h2>
        </div>

        <div class="payment-options">
                <span>
                    <label><input type="checkbox"> Direct Bank Transfer</label>
                </span>
                <span>
                    <label><input type="checkbox"> Check Payment</label>
                </span>
                <span>
                    <label><input type="checkbox"> Paypal</label>
                </span>
            </div>
    </div>
</section> <!--/#cart_items-->

@endsection
