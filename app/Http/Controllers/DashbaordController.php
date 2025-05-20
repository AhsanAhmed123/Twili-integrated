<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\attendent;

class DashbaordController extends Controller
{
    public function index(){
        $attendent =attendent::where('type','day')->get();
        return view('admin.index',compact('attendent'));
    }

    public function Day()
    {
        $attendent =attendent::where('type','day')->get();
        return view('admin.index',compact('attendent'));
    }

    public function night()
    {
        
        $night =attendent::where('type','night')->get();
        return view('admin.night-passes',compact('night'));
    }
}
