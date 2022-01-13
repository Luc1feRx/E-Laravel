<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Session;
session_start();

class HomeController extends Controller
{
    public function index(Request $request){
        //seo
        $meta_desc = "Thể hình phục vụ cuộc sống không để cuộc sống phục vụ thể hình. Là 1 gymer ngoài việc có body đẹp cần là 1 người có ích trong xã hội: trí tuệ, sức khỏe, sẻ chia";
        $meta_keyword = "thuc pham chuc nang";
        $url_canonical = $request->url();

        $cate_products = DB::table('tbl_category_products')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_products = DB::table('tbl_brand')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        // $listProduct = DB::table('tbl_product')
        // ->join('tbl_category_products','tbl_category_products.category_id', '=' ,'tbl_product.category_id')
        // ->join('tbl_brand','tbl_brand.brand_id', '=' ,'tbl_product.brand_id')
        // ->orderBy('tbl_product.product_id', 'desc')->get();

        $listProduct = DB::table('tbl_product')->where('product_status', '1')->orderBy('product_id', 'desc')->limit(4)->get();

        return view('pages.home')->with('categories', $cate_products)->with('brands', $brand_products)->with('products', $listProduct)
        ->with('meta_desc', $meta_desc)->with('meta_keyword', $meta_keyword)->with('url_canonical', $url_canonical);
    }

    public function SendMail(){
        $name = 'vu to qua';

        Mail::send('pages.mail.send_mail', compact('name'), function ($message) {
            $message->to('clgtqwe1@gmail.com', 'John Doe');
        });

    }

    public function Search(Request $request) {
        $keyword = $request->keyword_submit;
        $cate_products = DB::table('tbl_category_products')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_products = DB::table('tbl_brand')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        // $listProduct = DB::table('tbl_product')
        // ->join('tbl_category_products','tbl_category_products.category_id', '=' ,'tbl_product.category_id')
        // ->join('tbl_brand','tbl_brand.brand_id', '=' ,'tbl_product.brand_id')
        // ->orderBy('tbl_product.product_id', 'desc')->get();

        // $listProduct = DB::table('tbl_product')->where('product_status', '1')->orderBy('product_id', 'desc')->limit(4)->get();

        $search_product_by_keyword = DB::table('tbl_product')->where('product_name', 'like', '%'. $keyword . '%')->get();
        return view('pages.product.search')->with('categories', $cate_products)->with('brands', $brand_products)->with('search_product', $search_product_by_keyword);
    }
}
