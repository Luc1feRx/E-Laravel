<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
session_start();

class ProductController extends Controller
{
    public function AuthLogin(){
        $admin_id = session::get('admin_id');
        if($admin_id){
            return redirect()->route('dashboard');
        }else{
            return redirect()->route('admin-login')->send();
        }
    }
    public function AddProduct(){
        $this->AuthLogin();
        $cate_products = DB::table('tbl_category_products')->orderBy('category_id', 'desc')->get();
        $brand_products = DB::table('tbl_brand')->orderBy('brand_id', 'desc')->get();
        return view('admin.product.addProduct', compact('cate_products', $cate_products), compact('brand_products', $brand_products));
    }

    public function editProduct($product_id){
        $this->AuthLogin();
        $cate_products = DB::table('tbl_category_products')->orderBy('category_id', 'desc')->get();
        $brand_products = DB::table('tbl_brand')->orderBy('brand_id', 'desc')->get();
        $editProduct = DB::table('tbl_product')->where('product_id', $product_id)->get();
        return view('admin.product.editProduct', compact('editProduct', $editProduct), compact('cate_products', $cate_products))->with('brand_products', $brand_products);
    }


    public function deleteProduct($product_id, Request $request){
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->delete();
        $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Xóa Sản Phẩm Thành Công!</div>';
        $request->session()->put('message', $message);
        return redirect()->route('listProduct');
    }

    public function ListProduct(){
        $this->AuthLogin();
        $listProduct = DB::table('tbl_product')
        ->join('tbl_category_products','tbl_category_products.category_id', '=' ,'tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id', '=' ,'tbl_product.brand_id')
        ->orderBy('tbl_product.product_id', 'desc')->get();
        return view('admin.product.listProduct', compact('listProduct', $listProduct));
    }

    public function SaveProduct(Request $request){
        $this->AuthLogin();
        $request->validate([
            'product_name'=>'required'
        ]);
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_price'] = $request->product_price;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_category;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        $data['created_at'] = date('Y-m-d H:i:s');

        if($request->hasFile('product_image')){
            $get_image = $request->file('product_image');
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/upload/product', $new_image);
            $data['product_image'] = $new_image;
            $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Thêm Sản Phẩm Thành Công!</div>';
            DB::table('tbl_product')->insert($data);
            $request->session()->put('message', $message);
            return redirect()->route('listProduct');
        }
        $data['product_image'] = '';
        $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Thêm Sản Phẩm Thành Công!</div>';
        DB::table('tbl_product')->insert($data);
        $request->session()->put('message', $message);
        return redirect()->route('listProduct');
    }

    public function updateProduct(Request $request, $product_id){
        $this->AuthLogin();
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_price'] = $request->product_price;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_category;
        $data['brand_id'] = $request->product_brand;
        $data['updated_at'] = date('Y-m-d H:i:s');

        if($request->hasFile('product_image')){
            $get_image = $request->file('product_image');
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/upload/product', $new_image);
            $data['product_image'] = $new_image;
            $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Cập Nhật Sản Phẩm Thành Công!</div>';
            DB::table('tbl_product')->where('product_id', $product_id)->update($data);
            $request->session()->put('message', $message);
            return redirect()->route('editProduct', $product_id);
        }
        $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Cập Nhật Sản Phẩm Thành Công!</div>';
        DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        $request->session()->put('message', $message);
        return redirect()->route('listProduct');
    }

    public function UnactiveProduct($product_id, Request $request){
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status'=>0]);
        $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Ẩn Sản Phẩm Thành Công!</div>';
        $request->session()->put('message', $message);
        return redirect()->route('listProduct');
    }

    public function ActiveProduct($product_id, Request $request){
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status'=>1]);
        $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Hiển Thị Sản Phẩm Thành Công!</div>';
        $request->session()->put('message', $message);
        return redirect()->route('listProduct');
    }

    //end admin pages

    //start home pages

    public function ShowProductDetail($product_id){
        $cate_products = DB::table('tbl_category_products')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_products = DB::table('tbl_brand')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        $detailProduct = DB::table('tbl_product')
        ->join('tbl_category_products','tbl_category_products.category_id', '=' ,'tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id', '=' ,'tbl_product.brand_id')
        ->where('tbl_product.product_id', $product_id)->get();

        foreach($detailProduct as $value) {
            $category_id = $value->category_id;
        }

        $relatedProduct = DB::table('tbl_product')
        ->join('tbl_category_products','tbl_category_products.category_id', '=' ,'tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id', '=' ,'tbl_product.brand_id')
        ->where('tbl_category_products.category_id', $category_id)->whereNotIn('tbl_product.product_id', [$product_id])->get();

        return view('pages.product.show_detail_product')->with('categories', $cate_products)->with('brands', $brand_products)->with('detailProduct', $detailProduct)
        ->with('relatedProduct', $relatedProduct);
    }
}
