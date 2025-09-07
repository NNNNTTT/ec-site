<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $show = "index";
        return view('admin.index', compact('show'));
    }
}
