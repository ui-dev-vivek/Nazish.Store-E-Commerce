<?php

use App\Http\Controllers\Main\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', [Home::class, 'home']);
