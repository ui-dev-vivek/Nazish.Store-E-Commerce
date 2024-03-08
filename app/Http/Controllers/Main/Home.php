<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Home extends Controller
{
    public function home(Request $request)
    {
        $categories = Category::with('children')->whereNull('parent')->get();
        return view('main.home.home', compact('categories'));
    }
}
