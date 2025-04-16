<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\story;
use App\Models\follow;


class StoryControllers extends Controller
{
    public function show(Request $request){
        if(auth::check()){
            $user_following = follow::where('follower_id', Auth::id())->pluck('following_id')->toArray();
            $storys_users_id = story::whereIn('UID', $user_following)->orderBy('id')->select('UID')->groupBy('UID')->get();

            $show_all_story = collect(); // empty collection
            foreach($storys_users_id as $storys_user_id){
                $user_storys = story::where('UID', $storys_user_id['UID'])->get();
                $show_all_story = $show_all_story->merge($user_storys);
            }
    
            foreach ($show_all_story as $story) {
                $user = User::where('id', $story->UID)->select('id', 'user_name', 'first_name', 'last_name', 'profile_pic')->first();
                $story['user_id'] = $user['id'];
                $story['user_name'] = $user['user_name'];
                $story['first_name'] = $user['first_name'];
                $story['last_name'] = $user['last_name'];
                $story['user_profile_pic'] = $user['profile_pic'];
            }

            if(isset($request->user)){
                for($i=0; $i < count($show_all_story); $i++){
                    if($show_all_story[$i]['user_name'] == $request->user){
                        return view('home.story', ['all_story' => $show_all_story, 'show_story_number' => $i]);
                    }
                }
            }
    
            return view('home.story', ['all_story' => $show_all_story, 'show_story_number' => 0]);
        }else{
            return redirect()->route('signin');
        }
    }

    public function create(Request $request){

        if(auth::check()){
            $request->validate([
                'description' => 'required',
            ]);

            $inputs = $request->only([
                'description',
                'story_picture',
            ]);
    
            $inputs['UID'] = Auth::id();
            
            if ($request->hasFile('story_picture')) {
                $image = $request->file('story_picture');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('story-pictures'), $imageName);
                $inputs['story_picture'] = '/story-pictures/' . $imageName;
            }
    
            $story = story::create($inputs);
    
            if($story){
                notify()->success('add story successfully!');
                return redirect(route('home'));
            }
            return redirect()->back();
        }else{
            return redirect()->route('signin');
        }

    }
}
