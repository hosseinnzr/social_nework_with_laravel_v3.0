<?php

namespace App\Livewire\Story;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\notifications;
use App\Models\story;
use App\Models\user;
use App\Models\likeStory as like_story;


class LikeStory extends Component
{

    public $story;

    public $liked;

    public function like($story)
    {
        if(!like_story::where('UID',auth::id())->where('story_id', $story['id'])->exists())
        {
            like_story::create([
                'UID' => auth::id(),
                'story_id' => $story['id'],
                // 'type'=> 'like',
                'user_story_id' => $story['UID'],
            ]);

            if($story['UID'] != auth::id()){
                // send notifiction
                notifications::create([
                    'from' => auth::id(),
                    'to' => $story['UID'],
                    'body' => auth::user()->user_name,
                    'type'=> 'like_story',
                ]);

                // send email
                // $user = User::findOrFail($story['UID']);
                // if($user->like_notification == 1 && auth::id() != $story['UID']){
                //     $userName = Auth::user();
                //     Mail::to($user->email)->send(new likeNotifications($userName['user_name'], $story['id']));
                // }
            }

        }
    }

    public function dislike($story){

        $find_like_story = like_story::where('UID',auth::id())->where('story_id', $story['id']);

        $find_like_story->delete();
    }

    public function render()
    {
        if(like_story::where('UID',auth::id())->where('story_id', $this->story['id'])->exists()){
            $this->liked = 1;
        }else{
            $this->liked = 0;
        }

        $story = story::findOrFail($this->story['id']);

        // update like number
        $story->like_number = like_story::where('story_id', $this->story['id'])->count();
        $story->save();

        return view('livewire.story.like-story');
    }
}
