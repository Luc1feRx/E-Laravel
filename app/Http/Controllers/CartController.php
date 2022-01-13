<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
session_start();

class CartController extends Controller
{
    public function Save_Cart(Request $request){

        $data = $request->all();

        $product_infor = Product::where('product_id', $data['productid_hidden'])->first();

        $data['id'] = $product_infor->product_id;
        $data['qty'] = $data['qty'];
        $data['name'] = $product_infor->product_name;
        $data['price'] = $product_infor->product_price;
        $data['weight'] = '123';
        $data['options']['image'] = $product_infor->product_image;
        Cart::add($data);
        return redirect()->route('show-cart');
    }

    public function show_cart(){

        $cate_products = DB::table('tbl_category_products')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_products = DB::table('tbl_brand')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();
        return view('pages.cart.show_cart')->with('categories', $cate_products)->with('brands', $brand_products);
    }

    public function delete_cart($IdDelete){
        Cart::update($IdDelete, 0);
        return redirect()->route('show-cart');
    }

    public function Update_Cart(Request $request){
        $RowId = $request->RowId_cart;
        $qty = $request->quantity_cart;
        Cart::update($RowId, $qty);
        return redirect()->route('show-cart');
    }

    //add cart ajax
    public function AddToCart(Request $request){
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = $request->session()->get('cart');
        if ($cart == true){
            $is_available = 0;
            foreach ($cart as $item){
                if($item['product_id'] == $data['cart_product_id']){
                    $is_available++;
                }
            }
            if($is_available == 0){
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_id' => $data['cart_product_id'],
                    'product_name' => $data['cart_product_name'],
                    'product_image' => $data['cart_product_image'],
                    'product_qty' => $data['cart_product_qty'],
                    'product_price' => $data['cart_product_price']

                );
                $request->session()->put('cart', $cart);
            }
        }else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_id' => $data['cart_product_id'],
                'product_name' => $data['cart_product_name'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price']

            );
            $request->session()->put('cart', $cart);
        }
        $request->session()->save();
    }

    public function ShowCartAjax() {
        $cate_products = DB::table('tbl_category_products')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_products = DB::table('tbl_brand')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();
        return view('pages.cart.cart_ajax')->with('categories', $cate_products)->with('brands', $brand_products);
    }

    public function UpdateCartAjax(Request $request) {
        $data = $request->all();
        $cart = session()->get('cart');
        if($cart == true) {
            foreach($data['quantity_cart'] as $key => $qty){ //$key is session_id and $qty is corresponding value each key
                foreach($cart as $session => $value){
                    if($value['session_id'] == $key){
                        $cart[$session]['product_qty'] = $qty;
                    }
                }
            }
            $request->session()->put('cart', $cart);
            return redirect()->back()->with('message', 'Cart updated successfully.');
        }else{
            return redirect()->back()->with('message', 'Cart updated fail.');
        }
    }

    public function DeleteCartAjax($session_id){
        $cart = session()->get('cart');
        if($cart == true){
            foreach($cart as $key => $item){
                if($item['session_id'] == $session_id){
                    unset($cart[$key]);
                }
            }
            session()->put('cart', $cart);
            return redirect()->back()->with('message', 'Cart deleted successfully.');
        }else{
            return redirect()->back()->with('message', 'Cart deleted fail.');
        }
    }
}
