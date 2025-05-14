<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

use App\Models\Post;
use App\Models\User;
use App\Models\follow;
use App\Models\hashtag;

use App\Http\Controllers\Controller;

class PostController extends Controller
{   
    public function viewPost($id){
        if(auth::check()){
            $post = post::findOrFail($id);
            $user = User::findOrFail($post->UID);

            $check_follow = follow::where('follower_id',auth::id())->where('following_id', $post->UID)->exists();
            $check_privacy = $user['privacy'] == 'public';
            $check_post_UID = Auth::id() == $post['UID'];

            if($check_follow || $check_privacy || $check_post_UID){
                $post['user_id'] = $user['id'];
                $post['user_name'] = $user['user_name'];
                $post['user_profile_pic'] = $user['profile_pic'];
                $post['follow_state'] = $check_follow;

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
                'post_file' => 'required',
            ], [
                'post_file.required' => 'media filed required',
            ]);
            
            $inputs = $request->only([
                'post_file',
                'UID',
                'title',
                'post',
                'tag',
            ]);

            // hasgtag
            preg_match_all('/#([^#\s]+)/', $inputs['tag'], $matches);
            $tags = implode(",", $matches[1]);
            $tags_array = $matches[1];
            
            // If a new file was sent
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
                
                // write tag in database
                $inputs['tag'] = $tags;

                $inputs['UID'] = Auth::id();
                $post = Post::create($inputs);

                // update user post number
                $signin_user_post_number = Post::where('delete', 0)->where('UID', Auth::id())->count();
                $user = User::findOrFail(Auth::id());
                $user->post_number = $signin_user_post_number;
                $user->save();

                // update hashtag table
                foreach ($tags_array as $tag) {
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

    public function update(Request $request){
        if (isset($request->id)) {
            $request->validate([
                'post' => 'required',
            ]);

            $inputs = $request->only([
                'post',
                'title',
                'tag',
            ]);

            // hasgtag
            preg_match_all('/#([^#\s]+)/', $inputs['tag'], $matches);
            $tags = implode(",", $matches[1]);
            $tags_array = $matches[1];

            $post = Post::findOrFail($request->id);
            $oldPostPicture = $post->post_picture;
            $oldPostVideo = $post->post_video;
            $oldVideoCover = $post->video_cover;

            // If a new file was sent
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
                    $inputs['post_video'] = null;
                    $inputs['video_cover'] = null;

                    // آپدیت الگوریتم اکسپلور برای عکس جدید
                    $pythonFilePath = public_path('explore_algorithm/create_vector_single.py') . ' ' . $imageName;
                    $pythonExe = 'C:\\Users\\hossein\\AppData\\Local\\Programs\\Python\\Python313\\python.exe';
                    $command = $pythonExe . ' ' . $pythonFilePath;
                    $output = shell_exec($command);

                }
                // video
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

                // write tag in database
                $inputs['tag'] = $tags;
            }else {
                $inputs['post_picture'] = $oldPostPicture;
                $inputs['post_video'] = $oldPostVideo;
                $inputs['video_cover'] = $oldVideoCover;
                $inputs['tag'] = $tags;
            }

            // update hashtag table
            foreach ($tags_array as $tag) {
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
