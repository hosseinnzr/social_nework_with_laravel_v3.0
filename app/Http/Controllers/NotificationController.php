<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\notifications;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(){
        $notifications = notifications::latest()->where('to', Auth::id())->where('delete', '0')->get();
        return view('pages.notifications',[
            'user_notifications' => $notifications,
        ]);
    }

    public function destroy(){

    }
}
