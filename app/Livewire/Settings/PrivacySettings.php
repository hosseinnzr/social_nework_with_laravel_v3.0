<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Services\RequestServices;
use App\Models\User;
use App\Models\notifications;
use App\Models\followRequest;

class PrivacySettings extends Component
{
    public $isPrivate = false;

    public function togglePrivateAccount()
    {
        if(auth::user()->privacy == 'private'){
            $user_signin = User::where('id', auth::id())->first();
            $user_signin->update(['privacy' => 'public']);

            $find_notification_requests = 
            notifications::
                where('delete', '0')->
                where('type','follow_request')->
                where('to', Auth::id())->get();

                if(count($find_notification_requests) != 0){
                
                $authService = new RequestServices();

                for($i = 0; $i < count($find_notification_requests); $i++ ){
                    $follow_request = $find_notification_requests[$i];

                    $notificationid = $follow_request->id;
                    $userID = $follow_request->from;
                    $authService->acceptRequest($notificationid, $userID);
                }
            }
        }else{
            $user_signin = User::where('id', auth::id());
            $user_signin->update(['privacy' => 'private']);
        }
    }

    public function render()
    {
        if(auth::user()->privacy == 'private'){
            $this->isPrivate = true;
        }
        return view('livewire.settings.privacy-settings');
    }
}
