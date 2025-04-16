<?php

use App\Http\Controllers\AuthManager;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function () {
    return view('wellcome');
});
