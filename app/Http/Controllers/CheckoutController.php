<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Rules\Captcha;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
session_start();

class CheckoutController extends Controller
{

    public function AuthLogin(){
        $admin_id = session::get('admin_id');
        if($admin_id){
            return redirect()->route('dashboard');
        }else{
            return redirect()->route('admin-login')->send();
        }
    }

    public function Login_Checkout(){
        $cate_products = DB::table('tbl_category_products')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_products = DB::table('tbl_brand')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        return view('pages.checkout.login_checkout')->with('categories', $cate_products)->with('brands', $brand_products);
    }

    public function add_customer(Request $request){

        $request->validate([
            'customer_name' => 'required',
            'customer_email' => 'required',
            'customer_password' => 'required',
            'customer_phone' => 'required',
           'g-recaptcha-response' => new Captcha(), 		//dòng kiểm tra Captcha
        ]);

        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);
        $data['customer_phone'] = $request->customer_phone;
        $customer_id = DB::table('tbl_customer')->insertGetId($data);

        $request->session()->put('customer_id', $customer_id);
        $request->session()->put('customer_name', $request->customer_name);

        return redirect()->route('checkout')->with('message', 'Đăng ký tài khoản thành công,làm ơn đăng nhập');
    }

    public function Checkout(){
        $cate_products = DB::table('tbl_category_products')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_products = DB::table('tbl_brand')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        return view('pages.checkout.checkout')->with('categories', $cate_products)->with('brands', $brand_products);
    }

    public function saveCheckoutCustomer(Request $request){
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_note'] = $request->shipping_note;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_address'] = $request->shipping_address;

        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);
        $request->session()->put('shipping_id', $shipping_id);
        return redirect()->route('payment');
    }

    public function payment(){
        $cate_products = DB::table('tbl_category_products')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_products = DB::table('tbl_brand')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        return view('pages.checkout.payment')->with('categories', $cate_products)->with('brands', $brand_products);
    }

    //get payment methods
    public function OrderPlace(Request $request){
        $cate_products = DB::table('tbl_category_products')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_products = DB::table('tbl_brand')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        //insert payment methods
        $payment_data = array();
        $payment_data['payment_method'] = $request->payment_options;
        $payment_data['payment_status'] = 'Đang Chờ Xử Lý';

        $payment_id = DB::table('tbl_payment')->insertGetId($payment_data);
        $request->session()->put('payment_id', $payment_id);

        //insert order
        $order_data = array();
        $order_data['customer_id'] = $request->session()->get('customer_id');
        $order_data['shipping_id'] = $request->session()->get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total(0, ',', '.');
        $order_data['order_status'] = 'Đang Chờ Xử Lý';

        $order_id = DB::table('tbl_orders')->insertGetId($order_data);
        $request->session()->put('order_id', $order_id);

        //get product_id in cart
        $content = Cart::content();
        foreach ($content as $cart_content){
            //insert order_detail
            $order_detail_data = array();
            $order_detail_data['order_id'] = $order_id;
            $order_detail_data['product_id'] = $cart_content->id;
            $order_detail_data['product_name'] = $cart_content->name;
            $order_detail_data['product_price'] = $cart_content->price;
            $order_detail_data['product_sale_quantity'] = $cart_content->qty;

            $orderDetail_id = DB::table('order_detail')->insert($order_detail_data);
            $request->session()->put('order_detail_id', $orderDetail_id);
        }
        if($payment_data['payment_method'] == 1){
            echo 'Thanh Toán bằng ATM';
        }else if($payment_data['payment_method'] == 2){
            Cart::destroy();
            return view('pages.checkout.hashpayment')->with('categories', $cate_products)->with('brands', $brand_products);
        }else{
            echo 'Thẻ Ghi Nợ';
        }


        // return redirect()->route('payment');

        // return view('pages.checkout.payment')->with('categories', $cate_products)->with('brands', $brand_products);
    }

    public function logoutCheckout(Request $request){
        $request->session()->flush();
        return redirect()->route('login-checkout');
    }

    public function LoginCustomer(Request $request){
        $email_account = $request->email_account;
        $password = md5($request->password_account);
        $checkCus = Product::where('customer_email', $email_account)->where('customer_password', $password)->first();
        if($checkCus){
            $request->session()->put('customer_id', $checkCus->customer_id);
            return redirect()->route('checkout');
        }else{
            return redirect()->route('login-checkout');
        }
    }


    public function ManageOrder(){
        $listOrder = DB::table('tbl_orders')
        ->join('tbl_customer','tbl_customer.customer_id', '=' ,'tbl_orders.customer_id')
        ->join('tbl_shipping','tbl_shipping.shipping_id', '=' ,'tbl_orders.shipping_id')
        ->select('tbl_orders.*', 'tbl_shipping.shipping_name')
        ->orderBy('tbl_orders.order_id', 'desc')->get();

        return view('admin.order.manage_order')->with('listOrder', $listOrder);
    }

    public function ViewOrder($order_id){
        $this->AuthLogin();
        $Order_by_id = DB::table('tbl_orders')
        ->join('tbl_customer','tbl_customer.customer_id', '=' ,'tbl_orders.customer_id')
        ->join('tbl_shipping','tbl_shipping.shipping_id', '=' ,'tbl_orders.shipping_id')
        ->join('order_detail','order_detail.order_id', '=' ,'tbl_orders.order_id')
        ->select('tbl_orders.*', 'tbl_customer.*', 'tbl_shipping.*', 'order_detail.*')->where('tbl_orders.order_id', $order_id)
        ->get();
        // echo '<pre>';
        // print_r($Order_by_id);
        // echo '</pre>';
        return view('admin.order.view_order')->with('Order_by_id', $Order_by_id);
    }

    public function DeleteOrder(Request $request){


        return view('admin.order.manage_order');
    }
}
