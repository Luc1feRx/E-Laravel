<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;

class CategoryProducts extends Controller
{
    public function AddCategory(){
        return view('admin.category.addCategory');
    }

    public function editCategory($category_id){
        $editCategory = DB::table('tbl_category_products')->where('category_id', $category_id)->get();
        return view('admin.category.editCategory', compact('editCategory', $editCategory));

        // return redirect()->route('updateCategory-Products', $category_id)->with('editCategory', $editCategory);
    }


    public function deleteCategory($category_id, Request $request){
        DB::table('tbl_category_products')->where('category_id', $category_id)->delete();
        $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Xóa Danh Mục Sản Phẩm Thành Công!</div>';
        $request->session()->put('message', $message);
        return redirect()->route('listCategories-Products');
    }

    public function ListCategory(){
        $listCategory = DB::table('tbl_category_products')->get();
        return view('admin.category.ListCategory', compact('listCategory', $listCategory));
    }

    public function SaveCategory(Request $request){
        $data = array();
        $data['category_name'] = $request->name_category_product;
        $data['category_desc'] = $request->des_category_product;
        $data['category_status'] = $request->status_category_product;
        // $data['category_price'] =
        $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Thêm Danh Mục Sản Phẩm Thành Công!</div>';

        DB::table('tbl_category_products')->insert($data);
        $request->session()->put('message', $message);
        return Redirect::to('/add-category');
    }

    public function updateCategory(Request $request, $category_id){
        $data = array();
        $data['category_name'] = $request->name_category_product;
        $data['category_desc'] = $request->des_category_product;
        $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Cập Nhật Danh Mục Sản Phẩm Thành Công!</div>';

        DB::table('tbl_category_products')->where('category_id', $category_id)->update($data);
        $request->session()->put('message', $message);
        return redirect()->route('editCategory-Products', $category_id);
    }

    public function UnactiveCategory($category_id, Request $request){
        DB::table('tbl_category_products')->where('category_id', $category_id)->update(['category_status'=>0]);
        $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Ẩn Danh Mục Sản Phẩm Thành Công!</div>';
        $request->session()->put('message', $message);
        return Redirect::to('/list-categories');
    }

    public function ActiveCategory($category_id, Request $request){
        DB::table('tbl_category_products')->where('category_id', $category_id)->update(['category_status'=>1]);
        $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Hiển Thị Danh Mục Sản Phẩm Thành Công!</div>';
        $request->session()->put('message', $message);
        return Redirect::to('/list-categories');
    }

}
