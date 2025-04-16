<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Post;
use App\Models\User;
use App\Models\likePost as like_post;
use App\Models\notifications;
use App\Mail\notifications\likePost as likeNotifications;
use App\Mail\SendMail;
use Livewire\Component;

class LikePost extends Component
{
    public $post;

    public $liked;
    public function like($post)
    {
        if(!like_post::where('UID',auth::id())->where('post_id', $post['id'])->exists())
        {
            like_post::create([
                'UID' => auth::id(),
                'post_id' => $post['id'],
                // 'type'=> 'like',
                'user_post_id' => $post['UID'],
            ]);

            // send notifiction
            notifications::create([
                'from' => auth::id(),
                'to' => $post['UID'],
                'body' => auth::user()->user_name,
                'type'=> 'like',
            ]);

            // send email
            $user = User::findOrFail($post['UID']);
            if($user->like_notification == 1 && auth::id() != $post['UID']){
                $userName = Auth::user();
                Mail::to($user->email)->send(new likeNotifications($userName['user_name'], $post['id']));
            }
        }
    }


    public function dislike($post){

        $find_like_post = like_post::where('UID',auth::id())->where('post_id', $post['id']);

        $find_like_post->delete();
    }


    public function render()
    {        
        if(like_post::where('UID',auth::id())->where('post_id', $this->post['id'])->exists()){
            $this->liked = 1;
        }else{
            $this->liked = 0;
        }

        $post = Post::findOrFail($this->post['id']);

        // update like number
        $post->like_number = like_post::where('post_id', $this->post['id'])->count();
        $post->save();

        return view('livewire.like-post');
    }
}
