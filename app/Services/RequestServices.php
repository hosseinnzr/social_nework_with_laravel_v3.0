<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\notifications;
use App\Models\follow;
use App\Models\followRequest;

class RequestServices
{
    function acceptRequest($notificationid, $userID){
        $user_signin = User::findOrFail(auth::id());
        $user = User::findOrFail( $userID);

        // delete follow request
        $find_follow_user = followRequest::where('follower_id',$userID)->where('following_id', auth::id());
        $find_follow_user->delete();

        // add user to followr
        if(!follow::where('follower_id',$userID)->where('following_id', auth::id())->exists())
        {
            follow::create([
                'follower_id' => $userID,
                'following_id' => auth::id(),
            ]);
        }
        
        // send notifiction
        notifications::create([
            'UID' => $user_signin->id,
            'body' => $user->user_name,
            'type'=> 'accept Request',
            'frome' => Auth::id(),
            'user_profile' => Auth::user()->profile_pic,
        ]);

        // delete request notifiction
        $find_notification = notifications::where('id', $notificationid);
        $find_notification->delete();

        // update follow number
        $user_signin->followers_number = follow::where('following_id',auth::id())->count();
        $user_signin->save();       

        $user->following_number = follow::where('follower_id',$userID)->count();
        $user->save();
    }

    function deleteRequest($notificationid, $userID){
        // delete follow request
        $find_follow_user = followRequest::where('follower_id',$userID)->where('following_id', auth::id());

        $find_follow_user->delete();

        // delete request notifiction
        $find_notification = notifications::where('id', $notificationid);
        $find_notification->delete();
    }
}
