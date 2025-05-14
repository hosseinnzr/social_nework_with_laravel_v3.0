<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\RequestServices;

class FollowController extends Controller
{
    protected $authService;
    
    public function __construct(RequestServices $authService){
        $this->authService = $authService;
    }

    public function acceptRequest(Request $request){
        $notificationid = $request->input('notificationid');
        $userID = $request->input('userID');

        $this->authService->acceptRequest($notificationid, $userID);

        return redirect('notifications');
    }

    public function deleteRequest(Request $request){
        $notificationid = $request->input('notificationid');
        $userID = $request->input('userID');

        $this->authService->deleteRequest($notificationid, $userID);

        return redirect('notifications');
    }
}
