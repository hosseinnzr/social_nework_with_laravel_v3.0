<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Services\RequestServices;
use App\Models\User;

class Notifications extends Component
{
    public $like_notification = 0;
    public $comment_notification = 0;
    public $follow_notification = 0;
    public $follow_request_notification = 0;

    // like_notification
    public function toggleLikeNotification()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if($user->like_notification == 1){
            $user->like_notification = 0;
            $this->like_notification = 0;
        }else{
            $user->like_notification = 1;
            $this->like_notification = 1;
        }
        $user->save();

    }

    // comment_notification
    public function toggleCommentNotification()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if($user->comment_notification == 1){
            $user->comment_notification = 0;
            $this->comment_notification = 0;
        }else{
            $user->comment_notification = 1;
            $this->comment_notification = 1;
        }
        $user->save();
    }

    // follow_notification
    public function toggleFollowNotification()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if($user->follow_notification == 1){
            $user->follow_notification = 0;
            $this->follow_notification = 0;
        }else{
            $user->follow_notification = 1;
            $this->follow_notification = 1;
        }
        $user->save();
    }

    // follow_request_notification
    public function toggleFollowRequestNotification()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if($user->follow_request_notification == 1){
            $user->follow_request_notification = 0;
            $this->follow_request_notification = 0;
        }else{
            $user->follow_request_notification = 1;
            $this->follow_request_notification = 1;
        }
        $user->save();
    }

    public function render()
    {
        // like_notification
        if(auth::user()->like_notification == 1){
            $this->like_notification = 1;
        }

        // comment_notification
        if(auth::user()->comment_notification == 1){
            $this->comment_notification = 1;
        }

        // follow_notification
        if(auth::user()->follow_notification == 1){
            $this->follow_notification = 1;
        }

        // follow_request_notification
        if(auth::user()->follow_request_notification == 1){
            $this->follow_request_notification = 1;
        }
        return view('livewire.settings.notifications');
    }
}
