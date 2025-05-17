<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashbaordController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function Day(){
        return view('admin.index');
    }

    public function night(){
        return view('admin.index');
    }
}
