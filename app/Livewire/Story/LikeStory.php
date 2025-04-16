<?php

namespace App\Livewire\Story;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\notifications;
use App\Models\story;


class LikeStory extends Component
{

    public $story;

    public function like($story)
    {
        $id = $story['id'];
        $is_liked = false;
        $user_liked_id = auth::id();

        $story = story::findOrFail($id);

        $story_like = $story->like;

        $story_liked_array = explode(",", $story_like);

        foreach($story_liked_array as $like_number){

            if ($user_liked_id == $like_number){
                $story_liked_array = array_diff($story_liked_array, array($like_number));
                $like = implode(",", $story_liked_array);
                $is_liked = true;
                break;
            }
        }

        if(!$is_liked){
            if ($story->like != NULL) {
                $like = $story->like . ',' . $user_liked_id;
            } else {
                $like = $story->like . $user_liked_id;   
            }

            // send notifiction
            if($story->UID != Auth::id()){
                notifications::create([
                    'UID' => $story->UID,
                    'body' => Auth::user()->user_name,
                    'type'=> 'story',
                    'url' => "/s/$story->id",
                    'user_profile' => Auth::user()->profile_pic,
                ]);
            }
        }


        if ($story->like == ""){
            $like_number = 0;
        }else{
            $like_number = count(explode(",", $story->like));
        }

        // save like
        $story->like = $like;
        
        // save like_number
        $story->like_number = $like_number;
        $story->save();

        // dd($story);
        $this->story['like_number'] = $story->like_number;
    }

    public function render()
    {
        return view('livewire.story.like-story');
    }
}
