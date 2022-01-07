<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
session_start();

class HomeController extends Controller
{
    public function index(){
        $cate_products = DB::table('tbl_category_products')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_products = DB::table('tbl_brand')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        // $listProduct = DB::table('tbl_product')
        // ->join('tbl_category_products','tbl_category_products.category_id', '=' ,'tbl_product.category_id')
        // ->join('tbl_brand','tbl_brand.brand_id', '=' ,'tbl_product.brand_id')
        // ->orderBy('tbl_product.product_id', 'desc')->get();

        $listProduct = DB::table('tbl_product')->where('product_status', '1')->orderBy('product_id', 'desc')->limit(4)->get();

        return view('pages.home')->with('categories', $cate_products)->with('brands', $brand_products)->with('products', $listProduct);
    }
}
