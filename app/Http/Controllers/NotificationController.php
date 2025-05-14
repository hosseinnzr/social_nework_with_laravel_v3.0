<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\notifications;

class NotificationController extends Controller
{
    public function index(){
        $notifications = notifications::latest()->where('to', Auth::id())->where('delete', '0')->get();
        return view('pages.notifications',[
            'user_notifications' => $notifications,
        ]);
    }
}
