<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Home extends Controller
{
    public function home(Request $request)
    {
        // return Hash::make('info@123');
        return view('main.home.home');
    }
}
