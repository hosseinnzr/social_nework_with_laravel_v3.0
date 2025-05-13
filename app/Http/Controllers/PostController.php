<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\story;
use App\Models\follow;
use App\Models\likePost;
use App\Models\hashtag;

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
                'post_file' => 'required',
            ], [
                'post.required' => 'caption filed required',
                'post_file.required' => 'media filed required',
            ]);
            
            $inputs = $request->only([
                'post_file',
                'UID',
                'title',
                'post',
                'tag',
            ]);
            
            // image OR video
            if ($request->hasFile('post_file')) {
                $file = $request->file('post_file');
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
                    $pythonExe = 'C:\\Users\\hossein\\AppData\\Local\\Programs\\Python\\Python313\\python.exe';
                    
                    $command = '' . $pythonExe . ' ' . $pythonFilePath . '';

                    $output = shell_exec($command);
                }

                // video
                elseif (str_starts_with($mimeType, 'video/')) {
                    // ذخیره ویدیو
                    $videoName = time() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('post-video'), $videoName);
                    $inputs['post_video'] = $videoName;
                
                    // بررسی و ذخیره thumbnail ارسالی از فرانت
                    if ($request->has('video_thumbnail')) {
                        $base64Image = $request->input('video_thumbnail');
                
                        // جدا کردن فرمت و دیتا
                        [$type, $imageData] = explode(';', $base64Image);
                        [$meta, $imageData] = explode(',', $imageData);
                        $imageData = base64_decode($imageData);
                
                        // ساخت نام و ذخیره عکس
                        $thumbnailName = time() . '.jpg';
                        $thumbnailPath = public_path('video-cover/' . $thumbnailName);
                
                        // اطمینان از وجود پوشه
                        if (!file_exists(public_path('video-cover'))) {
                            mkdir(public_path('video-cover'), 0755, true);
                        }
                
                        file_put_contents($thumbnailPath, $imageData);
                
                        // ذخیره نام عکس کاور (thumbnail) در دیتابیس
                        $inputs['video_cover'] = $thumbnailName;  // ذخیره اسم کاور ویدیو
                    } else {
                        $inputs['video_cover'] = null;  // اگر هیچ کاوری نباشه
                    }
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

                $tags = explode(',', $inputs['tag']); // چند تگ رو جدا می‌کنیم

                foreach ($tags as $tag) {
                    if (empty($tag)) {
                        continue;
                    }

                    $existingTag = hashtag::where('name', $tag)->first();

                    if ($existingTag) {
                        hashtag::where('id', $existingTag->id)
                            ->update([
                                'number' => $existingTag->number + 1,
                                'updated_at' => now(),
                            ]);
                    } else {
                        hashtag::insert([
                            'name' => $tag,
                            'post_id' => '',
                            'number' => 1,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }

                notify()->success('Add post successfully!');
                
                return redirect()->route('post.store', ['id'=> $post->id])
                ->with('success', true);
            }

        }else{
            return redirect()->route('/signin');
        }
    }

    public function update(Request $request)
    {
        if (isset($request->id)) {
            $request->validate([
                'post' => 'required',
            ]);

            $inputs = $request->only([
                'post',
                'title',
                'tag',
            ]);

            $post = Post::findOrFail($request->id);
            $oldPostPicture = $post->post_picture;
            $oldPostVideo = $post->post_video;
            $oldVideoCover = $post->video_cover;

            // اگر فایل جدید فرستاده شده بود
            if ($request->hasFile('post_file')) {
                $file = $request->file('post_file');
                $mimeType = $file->getMimeType();

                // اگر عکس بود
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
                    $inputs['post_video'] = null;
                    $inputs['video_cover'] = null;

                    // آپدیت الگوریتم اکسپلور برای عکس جدید
                    $pythonFilePath = public_path('explore_algorithm/create_vector_single.py') . ' ' . $imageName;
                    $pythonExe = 'C:\\Users\\hossein\\AppData\\Local\\Programs\\Python\\Python313\\python.exe';
                    $command = $pythonExe . ' ' . $pythonFilePath;
                    $output = shell_exec($command);

                }
                // اگر ویدیو بود
                elseif (str_starts_with($mimeType, 'video/')) {
                    $videoName = time() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('post-video'), $videoName);
                    $inputs['post_video'] = $videoName;
                    $inputs['post_picture'] = null;

                    // بررسی و ذخیره thumbnail ارسالی از فرانت
                    if ($request->has('video_thumbnail')) {
                        [$type, $imageData] = explode(';', $request->input('video_thumbnail'));
                        [$meta, $imageData] = explode(',', $imageData);
                        $imageData = base64_decode($imageData);

                        $thumbnailName = time() . '.jpg';
                        $thumbnailPath = public_path('video-cover/' . $thumbnailName);

                        if (!file_exists(public_path('video-cover'))) {
                            mkdir(public_path('video-cover'), 0755, true);
                        }

                        file_put_contents($thumbnailPath, $imageData);
                        $inputs['video_cover'] = $thumbnailName;
                    } else {
                        $inputs['video_cover'] = null;
                    }
                }
            }

            // اگر فایل جدید نفرستاده بود ولی تگ و کپشن و ... عوض شده بود
            else {
                $inputs['post_picture'] = $oldPostPicture;
                $inputs['post_video'] = $oldPostVideo;
                $inputs['video_cover'] = $oldVideoCover;
            }

            // سازماندهی هشتگ‌ها
            $inputs['tag'] = substr(str_replace(',,', ',', str_replace('#', ',', str_replace(' ', '', $inputs['tag']))), 1);

            $tags = explode(',', $inputs['tag']); // چند تگ رو جدا می‌کنیم

            foreach ($tags as $tag) {
                if (empty($tag)) {
                    continue; // اگر خالی بود، رد شو
                }

                $existingTag = hashtag::where('name', $tag)->first();

                if ($existingTag) {
                    hashtag::where('id', $existingTag->id)
                        ->update([
                            'number' => $existingTag->number + 1,
                            'updated_at' => now(),
                        ]);
                } else {
                    hashtag::insert([
                        'name' => $tag,
                        'post_id' => '',
                        'number' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            $post->update($inputs);

            notify()->success('Update post successfully!');
            
            return redirect()->route('post', ['id' => $post->id])
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
