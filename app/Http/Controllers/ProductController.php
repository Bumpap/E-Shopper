<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
session_start();

class ProductController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id'); //Session::get('admin_id') la lay gia tri cua admin_id
        if($admin_id){
            return Redirect::to('dashboard'); //Redirect::to('dashboard') la chuyen huong den trang dashboard
        }else{
            return Redirect::to('admin')->send(); //send() la gui du lieu di
        }
    }
    public function add_product(){
        $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->orderby('brand_id', 'desc')->get();
        return view('admin.add_product')->with('cate_product', $cate_product)->with('brand_product', $brand_product);
    }
    public function all_product(){
        $this->AuthLogin();
        $all_product = DB::table('tbl_product')
        ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
        ->join('tbl_brand_product', 'tbl_brand_product.brand_id', '=', 'tbl_product.brand_id')
        ->orderby('tbl_product.product_id', 'desc')->get();
        //tbl_product la ten bang trong database
        $manager_product = view('admin.all_product')->with('all_product', $all_product);
        //all_product la ten cua bien trong file all_product.blade.php
        return view('admin_layout')->with('admin.all_product', $manager_product);
        //admin.all_product la ten cua file all_product.blade.php
    }
    public function save_product(Request $request){
        $this->AuthLogin();
        $data = array();
        $data['product_name'] = $request->product_name; //product_name la name cua the input
        //product_name la ten cot trong database
        $data['product_price'] = $request->product_price;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        // $data['product_image'] = $request->product_image;
        $get_image = $request->file('product_image'); //product_image la name cua the input
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            //getClientOriginalName() la lay ten file
            $name_image = current(explode('.', $get_name_image));
            //explode la cat chuoi theo ky tu truyen vao va tra ve mang
            //current la lay phan tu dau tien cua mang tra ve tu product_explode
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            //getClientOriginalExtension() la lay duoi file
            $get_image->move('uploads/product', $new_image);
            $data['product_image'] = $new_image; //product_image la ten cot trong database
            DB::table('tbl_product')->insert($data);
            Session::put('message', 'Thêm sản phẩm thành công');
            return Redirect::to('/add-product');
        }
        $data['product_image'] = '';
        DB::table('tbl_product')->insert($data);
        Session::put('message', 'Thêm sản phẩm thành công');
        return Redirect::to('/add-product');
    }
    public function unactive_product($product_id){
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status'=>1]);
        Session::put('message', 'Hiện sản phẩm thành công');
        return Redirect::to('/all-product');
    }
    public function active_product($product_id){
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status'=>0]);
        Session::put('message', 'Ẩn sản phẩm thành công');
        return Redirect::to('/all-product');
    }
    public function edit_product($product_id){
        $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->orderby('brand_id', 'desc')->get();

        $edit_product = DB::table('tbl_product')->where('product_id', $product_id)->get();
        $manager_product = view('admin.edit_product')->with('edit_product', $edit_product)
        ->with('cate_product', $cate_product)->with('brand_product', $brand_product);

        return view('admin_layout')->with('admin.edit_product', $manager_product);
    }
    public function update_product(Request $request, $product_id){
        $this->AuthLogin();
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_price'] = $request->product_price;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_image'] = $request->product_image;
        $get_image = $request->file('product_image'); //product_image la name cua the input

        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            //getClientOriginalName() la lay ten file
            $name_image = current(explode('.', $get_name_image));
            //explode la cat chuoi theo ky tu truyen vao va tra ve mang
            //current la lay phan tu dau tien cua mang tra ve tu product_explode
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            //getClientOriginalExtension() la lay duoi file
            $get_image->move('uploads/product', $new_image);
            $data['product_image'] = $new_image; //product_image la ten cot trong database
            DB::table('tbl_product')->where('product_id', $product_id)->update($data);
            Session::put('message', 'Cập nhật sản phẩm thành công');
            return Redirect::to('/all-product');
        }
        $data['product_image'] = '';
        DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        Session::put('message', 'Cập nhật sản phẩm thành công');
        return Redirect::to('/all-product');
    }
    public function delete_product($product_id){
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->delete();
        Session::put('message', 'Xóa sản phẩm thành công');
        return Redirect::to('/all-product');
    }
}
