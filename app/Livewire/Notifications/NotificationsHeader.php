<?php

namespace App\Livewire\Notifications;

use App\Models\User;
use Livewire\Component;
use App\Models\notifications;
use Illuminate\Support\Facades\Auth;
use App\Services\RequestServices;

class NotificationsHeader extends Component
{
    public $user_notifications;
    public $notificationid;
    public $userID;

    public function delete($notificationid)
    {
        $notification = notifications::findOrFail($notificationid);
        $notification->seen = "1";
        $notification->save();
    }

    public function acceptRequest($notificationid, $userID)
    {
        $authService = new RequestServices();
        $authService->acceptRequest($notificationid, $userID);
    }
    

    public function deleteRequest($notificationid, $userID)
    {
        $authService = new RequestServices();
        $authService->deleteRequest($notificationid, $userID);
    }

    public function render()
    {

        $this->user_notifications = notifications::latest()
            ->where('to', Auth::id())
            ->where('seen', 0)
            ->where('delete', '0')
            // ->limit(10)
            ->get();

        return view('livewire.notifications.notifications-header');
    }
}
