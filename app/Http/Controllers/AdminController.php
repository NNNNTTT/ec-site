<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // 管理画面トップを表示する
    public function index(){
        $show = "index";
        return view('admin.index', compact('show'));
    }
}
