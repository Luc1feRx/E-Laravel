<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
session_start();

class BrandProducts extends Controller
{
    public function AuthLogin(){
        $admin_id = session::get('admin_id');
        if($admin_id){
            return redirect()->route('dashboard');
        }else{
            return redirect()->route('admin-login')->send();
        }
    }
    public function AddBrand(){
        $this->AuthLogin();
        return view('admin.brand.addbrand');
    }
    public function editBrand($brand_id){
        $this->AuthLogin();
        $editbrand = DB::table('tbl_brand')->where('brand_id', $brand_id)->get();
        return view('admin.brand.editbrand', compact('editbrand', $editbrand));

        // return redirect()->route('updatebrand-Products', $brand_id)->with('editbrand', $editbrand);
    }


    public function deleteBrand($brand_id, Request $request){
        $this->AuthLogin();
        DB::table('tbl_brand')->where('brand_id', $brand_id)->delete();
        $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Xóa Danh Mục Sản Phẩm Thành Công!</div>';
        $request->session()->put('message', $message);
        return redirect()->route('listBrand');
    }

    public function Listbrand(){
        $this->AuthLogin();
        $listbrand = DB::table('tbl_brand')->get();
        return view('admin.brand.listbrand', compact('listbrand', $listbrand));
    }

    public function SaveBrand(Request $request){
        $this->AuthLogin();
        $data = array();
        $data['brand_name'] = $request->name_brand_product;
        $data['brand_desc'] = $request->des_brand_product;
        $data['brand_status'] = $request->status_brand_product;
        $data['created_at'] = date('Y-m-d H:i:s');
        // $data['brand_price'] =
        $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Thêm Thương Hiệu Sản Phẩm Thành Công!</div>';

        DB::table('tbl_brand')->insert($data);
        $request->session()->put('message', $message);
        return Redirect::to('/add-brand');
    }

    public function updateBrand(Request $request, $brand_id){
        $this->AuthLogin();
        $data = array();
        $data['brand_name'] = $request->name_brand_product;
        $data['brand_desc'] = $request->des_brand_product;
        $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Cập Nhật Thương Hiệu Sản Phẩm Thành Công!</div>';

        DB::table('tbl_brand')->where('brand_id', $brand_id)->update($data);
        $request->session()->put('message', $message);
        return redirect()->route('editBrand', $brand_id);
    }

    public function Unactivebrand($brand_id, Request $request){
        $this->AuthLogin();
        DB::table('tbl_brand')->where('brand_id', $brand_id)->update(['brand_status'=>0]);
        $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Ẩn Thương Hiệu Sản Phẩm Thành Công!</div>';
        $request->session()->put('message', $message);
        return redirect()->route('listBrand');
    }

    public function Activebrand($brand_id, Request $request){
        $this->AuthLogin();
        DB::table('tbl_brand')->where('brand_id', $brand_id)->update(['brand_status'=>1]);
        $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Hiển Thị Thương Hiệu Sản Phẩm Thành Công!</div>';
        $request->session()->put('message', $message);
        return redirect()->route('listBrand');
    }

        //end admin page

    //start home page
    public function ShowBrandHome($brand_id, Request $request){
        $cate_products = DB::table('tbl_category_products')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_products = DB::table('tbl_brand')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        $brand_by_id = DB::table('tbl_product')->join('tbl_brand', 'tbl_brand.brand_id', '=' ,'tbl_product.brand_id')
        ->where('tbl_product.brand_id', $brand_id)->get();

        $brand_by_name = DB::table('tbl_brand')->where('tbl_brand.brand_id', $brand_id)->limit(1)->get();
        return view('pages.brand.show_brand')->with('categories', $cate_products)->with('brands', $brand_products)->with('brand_by_id', $brand_by_id)->with('brand_by_name', $brand_by_name);

    }
}
