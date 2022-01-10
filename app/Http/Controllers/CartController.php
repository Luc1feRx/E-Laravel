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
}
