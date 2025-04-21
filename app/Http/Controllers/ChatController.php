<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class ChatController extends Controller
{
    public function index(){
        if(auth::check()){
            return response()->file(public_path('chat/index.php'));
        }else{
            return view('auth.signup');
        }
    }
}
