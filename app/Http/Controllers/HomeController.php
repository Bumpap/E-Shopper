<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
session_start();

class HomeController extends Controller
{
    public function index(){
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id', 'desc')->get();

        $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->orderby('brand_id', 'desc')->get();

        $all_product = DB::table('tbl_product')->where('product_status','1')->orderby('product_id', 'desc')->limit(4)->get();

        return view('pages.home')->with('category', $cate_product)->with('brand', $brand_product)->with('all_product', $all_product);
    }
}
