<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
session_start();

class CategoryProducts extends Controller
{
    public function AuthLogin(){
        $admin_id = session::get('admin_id');
        if($admin_id){
            return redirect()->route('dashboard');
        }else{
            return redirect()->route('admin-login')->send();
        }
    }
    public function AddCategory(){
        $this->AuthLogin();
        return view('admin.category.addCategory');
    }

    public function editCategory($category_id){
        $this->AuthLogin();
        $editCategory = Category::where('category_id', $category_id)->get();
        return view('admin.category.editCategory', compact('editCategory', $editCategory));

        // return redirect()->route('updateCategory-Products', $category_id)->with('editCategory', $editCategory);
    }


    public function deleteCategory($category_id, Request $request){
        $this->AuthLogin();
        Category::where('category_id', $category_id)->delete();
        $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Xóa Danh Mục Sản Phẩm Thành Công!</div>';
        $request->session()->put('message', $message);
        return redirect()->route('listCategories-Products');
    }

    public function ListCategory(){
        $this->AuthLogin();
        $listCategory = DB::table('tbl_category_products')->get();
        return view('admin.category.ListCategory', compact('listCategory', $listCategory));
    }

    public function SaveCategory(Request $request){
        $this->AuthLogin();
        $data = $request->all();
        $cate = new Category();
        $cate->category_name = $data['name_category_product'];
        $cate->category_desc = $data['des_category_product'];
        $cate->category_status = $data['status_category_product'];

        $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Thêm Danh Mục Sản Phẩm Thành Công!</div>';

        $cate->save();
        $request->session()->put('message', $message);
        return redirect()->route('addCategory-Products');
    }

    public function updateCategory(Request $request, $category_id){
        $this->AuthLogin();
        $data = array();
        $data['category_name'] = $request->name_category_product;
        $data['category_desc'] = $request->des_category_product;
        $data['slug_category'] = $request->slug_category;
        $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Cập Nhật Danh Mục Sản Phẩm Thành Công!</div>';

        DB::table('tbl_category_products')->where('category_id', $category_id)->update($data);
        $request->session()->put('message', $message);
        return redirect()->route('editCategory-Products', $category_id);
    }

    public function UnactiveCategory($category_id, Request $request){
        $this->AuthLogin();
        DB::table('tbl_category_products')->where('category_id', $category_id)->update(['category_status'=>0]);
        $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Ẩn Danh Mục Sản Phẩm Thành Công!</div>';
        $request->session()->put('message', $message);
        return redirect()->route('listCategories-Products');
    }

    public function ActiveCategory($category_id, Request $request){
        $this->AuthLogin();
        DB::table('tbl_category_products')->where('category_id', $category_id)->update(['category_status'=>1]);
        $message = '<div class="alert alert-success" style="font-size: 16px; text-align: center;">Hiển Thị Danh Mục Sản Phẩm Thành Công!</div>';
        $request->session()->put('message', $message);
        return redirect()->route('listCategories-Products');
    }
    //end admin page

    //start home page
    public function ShowCategoryHome($category_id){
        $cate_products = DB::table('tbl_category_products')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_products = DB::table('tbl_brand')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        $category_by_id = DB::table('tbl_product')->join('tbl_category_products', 'tbl_category_products.category_id', '=' ,'tbl_product.category_id')
        ->where('tbl_product.category_id', $category_id)->get();

        $category_by_name = DB::table('tbl_category_products')->where('tbl_category_products.category_id', $category_id)->limit(1)->get();
        return view('pages.category.show_category')->with('categories', $cate_products)->with('brands', $brand_products)->with('category_by_id', $category_by_id)
        ->with('category_by_name', $category_by_name);

    }
}
