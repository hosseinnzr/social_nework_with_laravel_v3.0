<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Post;
use App\Models\savePost;
use App\Models\follow;
use App\Models\story;
use App\Models\likePost;

class UserController extends Controller
{
    public function profile(Request $request, $user_name){
        if(auth::check()){
            if(User::where('user_name', $user_name)->exists()){
                if(User::where('user_name', $user_name)->first()['status'] == 'active'){
                    $user = User::where('user_name', $user_name)->first();
                    $posts = Post::latest()->where('delete', 0)->where('UID', $user->id)->get();

                    $find_save_posts_id = savePost::where('UID', auth::id())->pluck('post_id')->toArray();

                    $find_save_posts = Post::whereIn('id', $find_save_posts_id)->get();

                    foreach ($find_save_posts as $saved_post) {
                        $find_user = User::where('id', $saved_post->UID)->select('id', 'user_name', 'profile_pic')->first();
                        $saved_post['user_id'] = $find_user['id'];
                        $saved_post['user_name'] = $find_user['user_name'];
                        $saved_post['user_profile_pic'] = $find_user['profile_pic'];
                    }

                    if(isset($request->tag)){
                        $result = array();
                        foreach ($posts as $post) {
                            $post_array = explode(',', $post['tag']);
                            if ((in_array($request->tag, $post_array)) != false){
                                array_push($result, $post);
                            }
                            $posts=$result;
                        } 
                    }

                    $user_follower = Follow::where('following_id', $user->id)->pluck('follower_id')->toArray();
                    $user_following = Follow::where('follower_id', $user->id)->pluck('following_id')->toArray();

                    $follower_user = User::whereIn('id', $user_follower)->select('user_name', 'first_name', 'last_name', 'profile_pic')->get();
                    $following_user = User::whereIn('id', $user_following)->select('user_name', 'first_name', 'last_name', 'profile_pic')->get();
                    
                    // check follow
                    $check_follow = false;
                    $check_follow = follow::where('follower_id',auth::id())->where('following_id', $user['id'])->exists();

                    return view('pages.profile', [
                        'check_follow' => $check_follow,
                        'save_posts' => $find_save_posts,
                        'posts' => $posts,
                        'user' => $user,
                        'follower_user' => $follower_user,
                        'following_user' => $following_user,
                    ]);   
                }else{
                    notify()->error('user not active');
                    return back();
                }
            }else{
                notify()->error('user not found');
                return back();
            }
                 
        } else {
            notify()->error('you not signin');
            return redirect()->route('signin');
        }
    }

    public function home(Request $request){
        if(auth::check()){

            $user_following = follow::where('follower_id', Auth::id())->pluck('following_id')->toArray();
            $user_follower = follow::where('following_id', Auth::id())->pluck('follower_id')->toArray();

            $signin_user_id = Auth::id();

            $new_users = User::all()->sortByDesc('id')->whereNotIn('id', $user_following)->whereNotIn('id', $user_follower)->where('id', '!=', $signin_user_id)->take(5);

            $posts = Post::latest()->where('delete', 0)->whereIn('UID', $user_following)->get();

            $user_have_story = array_merge([strval(auth::id())], $user_following);

            $order = "CASE";
            foreach ($user_have_story as $index => $uid) {
                $order .= " WHEN UID = $uid THEN $index";
            }
            $order .= " END";

            $storys = story::whereIn('UID', $user_have_story)
                        ->select('id', 'UID')
                        ->orderByRaw($order)
                        ->groupBy('UID')
                        ->get();

            foreach ($storys as $story) {
                $user = User::where('id', $story->UID)->select('user_name', 'profile_pic')->first();
                $story['user_name'] = $user['user_name'];
                $story['user_profile_pic'] = $user['profile_pic'];
            }
            
            foreach ($posts as $post) {
                $user = User::where('id', $post->UID)->select('id', 'user_name', 'profile_pic')->first();
                $post['user_id'] = $user['id'];
                $post['user_name'] = $user['user_name'];
                $post['user_profile_pic'] = $user['profile_pic'];
            }

            $follower_user = User::whereIn('id', $user_follower)->select('user_name', 'first_name', 'last_name', 'profile_pic')->get();
            $following_user = User::whereIn('id', $user_following)->select('user_name', 'first_name', 'last_name', 'profile_pic')->get();

            return view('home.home', [
                'posts' => $posts,
                'follower_user' => $follower_user,
                'following_user' => $following_user,
                'new_users' => $new_users,
                'storys' => $storys,
            ]);    
            
        } else {
            return redirect()->route('signin');
        }
    }

    public function explore(Request $request){
        if(auth::check()){
            if (isset($request->tag)) {
                $hash_tag = $request->tag;
                $find_posts = Post::where('delete', 0)
                            ->whereRaw("FIND_IN_SET(?, tag)", [ $hash_tag])
                            ->orderBy('created_at', 'desc')
                            ->get();
            }else{
                $user_liked_post = likePost::where('UID', Auth::id())->pluck('post_id')->toArray(); // with out video
            
                $liked_posts = Post::where('delete', 0)->whereIn('id', $user_liked_post)->whereNot('post_picture', null)->get();
                $found_image_name = [];

                // Example: python find_similar_faiss.py 12323423.png 5

                // find same post for show in explor
                foreach ($liked_posts as $post) {
                    $imageName = $post->post_picture;

                    $pythonFilePath = public_path('explore_algorithm/find_similar.py') . ' ' . $imageName;
                    $pythonExe = 'C:\\Users\\hossein\\AppData\\Local\\Programs\\Python\\Python313\\python.exe';

                    $command = '' . $pythonExe . ' ' . $pythonFilePath . ' ';
                    $output = shell_exec($command);

                    $clean = str_replace(["[", "]", "'"], "", $output);
                    $array = explode(", ", $clean);

                    $found_image_name = array_merge($found_image_name, $array);
                }
                
                $found_image_name = array_unique($found_image_name);
                
                $hash_tag = null;

                $find_posts = Post::where('delete', 0)->orderBy('created_at', 'desc');
                
                if (!empty($found_image_name)) {
                    $find_posts->where(function ($query) use ($found_image_name) {
                        foreach ($found_image_name as $name) {
                            $query->orWhere('post_picture', 'like', '%' . trim($name) . '%');
                        }
                    });
                }
                
                $find_posts = $find_posts->get();
            }

            foreach ($find_posts as $post) {
                $user = User::where('id', $post->UID)->select('id', 'user_name', 'profile_pic')->first();
                $post['user_id'] = $user['id'];
                $post['user_name'] = $user['user_name'];
                $post['user_profile_pic'] = $user['profile_pic'];
            }

            return view('pages.explore', [
                'hash_tag' => $hash_tag,
                'posts' => $find_posts,
            ]);    
            
        } else {
            return redirect()->route('signin');
        }
    }

    public function settingsRoute(){
        if(auth::check()){
            return view('pages.settings');
        }else{
            notify()->error('you not sign in');
            return redirect()->route('signin');
        }
    }

    public function settingsPost(Request $request){
        $userId = Auth::id();
        $user =  User::findOrFail($userId);

        $request->validate([
            'user_name' => 'required|unique:users,user_name,' . $user->id,
            'phone' => 'required|max:11|unique:users,phone,' . $user->id,
            'biography' => 'max:150',
        ]);

        $input = $request->only([
            'birthday',
            'profile_pic' ,
            'biography',
            'birthday',
            'first_name',
            'last_name',
            'user_name',
            'phone',
            'additional_name'
        ]);

        if($user['user_name'] != $input['user_name']){
            // update session for chat
            DB::update("
                UPDATE messages
                SET 
                    sender = CASE WHEN sender = ? THEN ? ELSE sender END,
                    receiver = CASE WHEN receiver = ? THEN ? ELSE receiver END
                WHERE sender = ? OR receiver = ?
            ", [
                $user['user_name'], $input['user_name'],
                $user['user_name'], $input['user_name'],
                $user['user_name'], $user['user_name']
            ]);

            // update session[user_name] for chat
            session_start();
            $_SESSION['user'] = [
                'id' => Auth::id(),
                'user_name' => $input['user_name'],
                'profile_pic' => $user['profile_pic'],
            ];
        }

        if ($request->hasFile('profile_pic')) {
            $image = ($request->file('profile_pic'));
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('profile'), $imageName);
            $input['profile_pic'] = '/profile/'.$imageName;

            // update session[profile_pic] for chat
            $_SESSION['user'] = [
                'id' => Auth::id(),
                'user_name' => $input['user_name'],
                'profile_pic' => $input['profile_pic'],
            ];
        }

        $user->update($input);

        notify()->success('update user successfully!');
        return redirect()->route('settings');
        
    }
}
