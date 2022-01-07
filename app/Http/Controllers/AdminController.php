<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
session_start();
class AdminController extends Controller
{
    //login
    public function index(){
        return view('admin_login');
    }
    public function AuthLogin(){
        $admin_id = session::get('admin_id');
        if($admin_id){
            return redirect()->route('dashboard');
        }else{
            return redirect()->route('admin-login')->send();
        }
    }
    //dashboard
    public function ShowDashboard(){
        $this->AuthLogin();
        return view('admin.dashboard');
    }

    //Xu ly phan dang nhap
    public function dashboard(Request $request){
        $email = $request->admin_email;
        $password = md5($request->admin_password);

        $result = DB::table('tbl_admin')->where('admin_email', $email)->where('admin_password', $password)->first();
        if($result){
            $request->session()->put('admin_name', $result->admin_name);
            $request->session()->put('admin_id', $result->admin_id);
            return redirect()->route('dashboard');
        }else{
            $request->session()->put('message', '<div class="alert alert-danger" style="font-size: 16px; text-align: center;">Mật khẩu hoặc tài khoản bị sai!!!</div>');
            return Redirect::to('/admin');

        }
    }

    //dang xuat
    public function logout(Request $request){
        $this->AuthLogin();
        $request->session()->put('admin_name', null);
        $request->session()->put('admin_id', null);
        return Redirect::to('/admin');
    }
}
