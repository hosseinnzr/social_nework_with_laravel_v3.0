<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\savePost;
use App\Models\follow;
use App\Services\RequestServices;

use Exception;

class AuthManager extends Controller
{
    protected $authService;
    public function __construct(RequestServices $authService)
    {
        $this->authService = $authService;
    }

    function profile(Request $request, $user_name){
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


    // follow request
    public function acceptRequest(Request $request)
    {
        $notificationid = $request->input('notificationid');
        $userID = $request->input('userID');

        $this->authService->acceptRequest($notificationid, $userID);

        return redirect('notifications');
    }


    function deleteRequest(Request $request)
    {
        $notificationid = $request->input('notificationid');
        $userID = $request->input('userID');

        $this->authService->deleteRequest($notificationid, $userID);

        return redirect('notifications');
    }


    // signin / signUp / logout
    function signin(Request $request){
        if(auth::check()){
            notify()->success('you are now signin');
            return redirect()->route('home');  
        }else{
            return view('signin',[
                'redirect' => $request->query('r')
            ]);
        }
    }

    function signinPost(Request $request, $redirect = null){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
        if(Auth::attempt($credentials)){

            if(Auth::user()->status == "active"){         
                $request->session()->regenerate();

                notify()->success('signup successfully');

                $redirect = $request['redirect'];
                if ($redirect) {
                    return redirect($redirect);
                }

                return redirect()->route('home');

            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            notify()->success('account not found');
            return redirect()->route('signin');
        }
        
        return redirect(route('signin'))->with('error', 'signin details are not valid');
    }

    // public function signupPost(Request $request){ 

    //     $request->validate([
    //         'profile_pic',
    //         'first_name' => 'required',
    //         'last_name' => 'required',
    //         'user_name' => 'required|unique:users',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required',
    //     ]);

    //     $data['first_name'] = $request->first_name;
    //     $data['last_name'] = $request->last_name;
    //     $data['user_name'] = $request->user_name;
    //     $data['email'] = $request->email;
    //     $data['password'] = Hash::make($request->password);
    //     $data['profile_pic'] = '/default/default_profile.jpg';

    //     $user = User::create($data);
    //     if($user){
    //         notify()->success('signup user successfully!');
    //         return redirect(route('signin'));
    //     }
    //     return redirect()->back();
    // }  #### Written by Livw Wire ####
 
    function signup(){
        if(auth::check()){
            notify()->success('you are now signin');
            return redirect()->route('home');  
        }else{
            return view('signup');
        }
    }

    function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
 
        $request->session()->regenerateToken();

        notify()->success('signout user successfully!');
         
        return redirect()->route('signin');
    }
    
    // forgot password
    public function forgotPassword(){
        if(Auth::check()){
            return redirect()->route('home');
        }else{
            return view('forgotPassword');
        }
    } 

    // edit / update
    public function settings(){
        if(auth::check()){
            return view('pages.settings');
        }else{
            notify()->error('you not sign in');
            return redirect()->route('signin');
        }
    }
    public function update(Request $request){

        $userId = Auth::id();

        $user =  User::findOrFail($userId);

        $request->validate([
            'user_name' => 'required|unique:users,user_name,' . $user->id,
            'phone' => 'required|max:11|unique:users,phone,' . $user->id,
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

        if ($request->hasFile('profile_pic')) {
            $image = ($request->file('profile_pic'));
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('profile'), $imageName);
            $input['profile_pic'] = '/profile/'.$imageName;
        }

        $user->update($input);

        notify()->success('update user successfully!');
        return redirect()->route('settings');
        
    }
    public function deletePost($id){
        try {
            $status = Post::where(['id' => $id]) -> delete();

            if($status){
                $result = "the post id : $id delete successfuly";
                return Response()->json( $result , 200); 
            }else{
                $result = "Delteing the post id : $id is failed!";
                return Response()->json( $result ,401);
            }
        } catch (Exception $error) {
            return Response()->json($error, 400);
        }
    }

    // delete account
    public function deleteAccount(Request $request){
        if(auth::check()){
            $userId = Auth::id();
            $user =  User::findOrFail($userId);

            $request->validate([
                'why' => 'required',
                'checkbox' => 'required',
            ]);
    
            $user->status = 'delete';
            $user->save();
                
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            notify()->success('delete account successfully!');
             
            return redirect()->route('signin');

        }else{
            return view('signin');
        }
    }
}
