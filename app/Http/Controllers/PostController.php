<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\story;
use App\Models\follow;
use App\Models\likePost;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

use App\Http\Controllers\Controller;

class PostController extends Controller
{   

    public function home(Request $request){
        if(auth::check()){

            $user_following = follow::where('follower_id', Auth::id())->pluck('following_id')->toArray();
            $user_follower = follow::where('following_id', Auth::id())->pluck('follower_id')->toArray();

            $signin_user_id = Auth::id();

            $new_users = User::all()->sortByDesc('id')->whereNotIn('id', $user_following)->whereNotIn('id', $user_follower)->where('id', '!=', $signin_user_id)->take(5);

            $posts = Post::latest()->where('delete', 0)->whereIn('UID', $user_following)->get();

            $hash_tag = null;

            $storys = story::whereIn('UID', $user_following)->orderBy('id')->select('id', 'UID')->groupBy('UID')->get();

            foreach ($storys as $story) {
                $user = User::where('id', $story->UID)->select('user_name', 'profile_pic')->first();
                $story['user_name'] = $user['user_name'];
                $story['user_profile_pic'] = $user['profile_pic'];
            }

            if(isset($request->tag)){
                $hash_tag = $request->tag;
                $result = array();
                foreach ($posts as $post) {
                    $post_array = explode(',', $post['tag']);
                    if ((in_array('#'.$request->tag, $post_array)) == true){
                        array_push($result, $post);
                    }
                    $posts=$result;
                } 
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
                'hash_tag' => $hash_tag,
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

            $user_liked_post = likePost::where('UID', Auth::id())->pluck('post_id')->toArray();
            // $user_saved_post = savePost::where('UID', Auth::id());
            $liked_posts = Post::where('delete', 0)->whereIn('id', $user_liked_post)->get();
            $found_image_name = [];

            // python find_similar_faiss.py 12323423.png 5

            foreach ($liked_posts as $post) {
                $imageName = $post->post_picture;

                $pythonFilePath = public_path('explore_algorithm/find_similar.py') . ' ' . $imageName;
                $pythonExe = 'C:\\Users\\nazari\\AppData\\Local\\Programs\\Python\\Python313\\python.exe';

                $command = '' . $pythonExe . ' ' . $pythonFilePath . ' ';
                $output = shell_exec($command);

                $clean = str_replace(["[", "]", "'"], "", $output);
                $array = explode(", ", $clean);

                $found_image_name = array_merge($found_image_name, $array);
            }
            
            $found_image_name = array_unique($found_image_name);
            // dd($found_image_name);
            $hash_tag = null;
            
            // if(isset($request->tag)){


            //     $new_users = User::all()->sortByDesc('id')->whereNotIn('id', $user_following)->whereNotIn('id', $user_follower)->where('id', '!=', $signin_user_id)->take(5);

            //     $posts = Post::where('delete', 0)->whereIn('id', $user_liked_post)->get();

            //     $hash_tag = $request->tag;
            //     $result = array();
            //     foreach ($posts as $post) {
            //         $post_array = explode(',', $post['tag']);
            //         if ((in_array($request->tag, $post_array)) == true){
            //             array_push($result, $post);
            //         }
            //         $posts=$result;
            //     } 
            // }

            
            $find_posts = Post::where('delete', 0)->orderBy('created_at', 'desc');

            if (!empty($found_image_name)) {
                $posts = $find_posts->where(function ($query) use ($found_image_name) {
                    foreach ($found_image_name as $name) {
                        $query->orWhere('post_picture', 'like', '%' . trim($name) . '%');
                    }
                });
            }else{
                $posts = $find_posts->get();
            }

            $find_posts = $find_posts->get();
            foreach ($find_posts as $post) {
                $user = User::where('id', $post->UID)->select('id', 'user_name', 'profile_pic')->first();
                $post['user_id'] = $user['id'];
                $post['user_name'] = $user['user_name'];
                $post['user_profile_pic'] = $user['profile_pic'];
            }


            $follower_user = follow::where('following_id', Auth::id())->get();
            $following_user = follow::where('follower_id', Auth::id())->get();

            return view('pages.explore', [
                'hash_tag' => $hash_tag,
                'posts' => $find_posts,
                'follower_user' => $follower_user,
                'following_user' => $following_user,
                // 'new_users' => $new_users,
            ]);    
            
        } else {
            return redirect()->route('signin');
        }
    }

    public function viewPost($id){
        if(auth::check()){
            $post = post::findOrFail($id);
            $user = User::findOrFail($post->UID);

            if(follow::where('follower_id',auth::id())->where('following_id', $post->UID)->exists() || $user['privacy'] == 'public' || Auth::id() == $post['UID']){
                $post['user_id'] = $user['id'];
                $post['user_name'] = $user['user_name'];
                $post['user_profile_pic'] = $user['profile_pic'];

                return view('posts.viewPost', ['post' => $post]);
            }else{
                return redirect('/user/'.$user['user_name']);
            }

        }else{
            return redirect('signin/?r=/p/'.$id);
        }
    }

    public function postRoute(Request $request,){
        if(isset($request->id)){
            $post = Post::findOrFail($request->id);

            if(Auth::user()->id != $post['UID']){
                notify()->error('you do not have access');
                return back();
            }else{
                return view('posts.post', ['post' => $post]);
            }

        }else{
            return view('posts.post');
        }
    }
    
    public function create(Request $request){

        if (Auth::check()) {

            $request->validate([
                'post' => 'required',
            ]);

            $inputs = $request->only([
                'post_picture',
                'UID',
                'title',
                'post',
                'tag',
            ]);
            
            // image OR video
            if ($request->hasFile('post_picture')) {
                $file = $request->file('post_picture');
                $mimeType = $file->getMimeType();

                // image
                if (str_starts_with($mimeType, 'image/')) {
                    $imageName = time() . '.' . $file->getClientOriginalExtension();
                    $manager = new ImageManager(new Driver());
                    $img = $manager->read($file);

                    $width = $img->width();
                    $height = $img->height();
                    $size = min($width, $height);
                    $x = ($width - $size) / 2;
                    $y = ($height - $size) / 2;

                    $img->crop($size, $size, $x, $y);
                    $img->save(public_path('post-picture/' . $imageName));
                    $inputs['post_picture'] = $imageName;

                    // update explore algorithm
                    $pythonFilePath = public_path('explore_algorithm/create_vector_single.py') . ' ' . $imageName;
                    $pythonExe = 'C:\\Users\\nazari\\AppData\\Local\\Programs\\Python\\Python313\\python.exe';
                    
                    $command = '' . $pythonExe . ' ' . $pythonFilePath . '';

                    $output = shell_exec($command);
                }

                // video
                elseif (str_starts_with($mimeType, 'video/')) {
                    $videoName = time() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('post-video'), $videoName);
                    $inputs['post_video'] = $videoName;
                    $inputs['post_picture'] = null;
                }

                $inputs['UID'] = Auth::id();
                $post = Post::create($inputs);

                // update user post number
                $signin_user_post_number = Post::where('delete', 0)->where('UID', Auth::id())->count();
                $user = User::findOrFail(Auth::id());
                $user->post_number = $signin_user_post_number;
                $user->save();

                // Organize hash tag
                $inputs['tag'] = substr(str_replace(',,', ',', str_replace('#', ',',str_replace(' ', '', $inputs['tag']))), 1);

                notify()->success('Add post successfully!');
                
                return redirect()->route('post.store', ['id'=> $post->id])
                ->with('success', true);
            }

        }else{
            return redirect()->route('/signin');
        }
    }

    public function update(Request $request){

        if (isset($request->id)) {
            
            $request->validate([
                'post' => 'required',
            ]);

            $inputs = $request->only([
                'post_picture',
                'title',
                'post',
                'tag',
            ]);

            if ($request->hasFile('post_picture')) {
                $image = $request->file('post_picture');
                $imageName = time() . '.' . $image->getClientOriginalExtension();

                // create image manager with desired driver
                $manager = new ImageManager(new Driver());

                // Load image using Intervention Image
                $img = $manager->read($image);

                // Get dimensions to calculate cropping coordinates
                $width = $img->width();
                $height = $img->height();
                $size = min($width, $height);
                $x = ($width - $size) / 2;
                $y = ($height - $size) / 2;

                // Crop the image to a square
                $img->crop($size, $size, $x, $y);

                // Save the image to the public directory
                $img->save(public_path('post-picture/' . $imageName));

                $inputs['post_picture'] = $imageName;
            }

            // Organize hash tag
            $inputs['tag'] = substr(str_replace(',,', ',', str_replace('#', ',',str_replace(' ', '', $inputs['tag']))), 1);


            $post = Post::findOrFail($request->id);
            $post->update($inputs);

            // update explore algorithm
            $pythonFilePath = public_path('explore_algorithm/create_vector_single.py') . ' ' . $imageName;
            $pythonExe = 'C:\\Users\\nazari\\AppData\\Local\\Programs\\Python\\Python313\\python.exe';
            
            $command = '' . $pythonExe . ' ' . $pythonFilePath . '';

            $output = shell_exec($command);

            notify()->success('Update post successfully!'. $output);

            return redirect()
                ->route('post', ['id' => $post->id])
                ->with('success', true);
        } else {
            return redirect()->route('/signin');
        }

    }

    public function delete(Request $request){
        $post = Post::findOrFail($request->id);
        $post->update(['delete' => true]);

        // update user post number
        $signin_user_post_number = Post::where('delete', 0)->where('UID', Auth::id())->count();
        $user = User::findOrFail(Auth::id());
        $user->post_number = $signin_user_post_number;
        $user->save();
        
        return redirect()->back();
    }

}
