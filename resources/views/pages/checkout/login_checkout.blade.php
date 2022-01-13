@extends('layout')
@section('contents')

<section id="form"><!--form-->
    <div class="container">
        <div class="row">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form"><!--login form-->
                    <h2>Đăng Nhập Tài Khoản</h2>
                    <form action="{{ route('login-customer') }}" method="post">
                        {{ csrf_field() }}
                        <input type="text" name="email_account"  placeholder="Tài Khoản" />
                        <input type="password" name="password_account" placeholder="Mật Khẩu" />
                        <span>
                            <input type="checkbox" class="checkbox">
                            Nhớ Tôi
                        </span>
                        <button type="submit" class="btn btn-default">Đăng Nhập</button>
                    </form>
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">Hoặc</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    <h2>Đăng Ký</h2>
                    <form action="{{ route('add-customer') }}" method="post">
                        {{ csrf_field() }}
                        <input type="text" name="customer_name" placeholder="Họ Tên"/>
                        <input type="email" name="customer_email" placeholder="Email"/>
                        <input type="password" name="customer_password" placeholder="Mật Khẩu"/>
                        <input type="text" name="customer_phone" placeholder="Số Điện Thoại"/>
                        <div class="g-recaptcha" data-sitekey="{{env('CAPTCHA_KEY')}}"></div>
                        <br/>
                        @if($errors->has('g-recaptcha-response'))
                        <span class="invalid-feedback" style="display:block">
                            <strong>{{$errors->first('g-recaptcha-response')}}</strong>
                        </span>
                        @endif

                        <button type="submit" class="btn btn-default">Đăng Ký</button>
                    </form>
                </div><!--/sign up form-->
            </div>
        </div>
    </div>
</section><!--/form-->

@endsection
