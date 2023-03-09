<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

session_start();

class AdminController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id'); //Session::get('admin_id') la lay gia tri cua admin_id
        if($admin_id){
            return Redirect::to('dashboard'); //Redirect::to('dashboard') la chuyen huong den trang dashboard
        }else{
            return Redirect::to('admin')->send(); //send() la gui du lieu di
        }
    }
    public function index(){
        return view('admin_login');
    }
    public function show_dashboard(){
        $this->AuthLogin();
        return view('admin.dashboard');
    }
    public function dashboard(Request $request){
        $admin_email = $request->admin_email;
        $admin_password = md5($request->admin_password);

        $result = DB::table('tbl_admin')->where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
        if($result){
            $request->session()->put('admin_name', $result->admin_name);
            $request->session()->put('admin_id', $result->admin_id);
            return Redirect::to('/dashboard');
        }else{
            $request->session()->put('message', 'Mật khẩu hoặc tài khoản không đúng');
            return Redirect::to('/admin');
        }
    }
    public function logout(){
        $this->AuthLogin();
        Session::put('admin_name', null);
        Session::put('admin_id', null);
        return Redirect::to('/admin');
    }
}
