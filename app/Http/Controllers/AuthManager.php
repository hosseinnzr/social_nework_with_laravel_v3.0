<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthManager extends Controller
{
    function signin(Request $request){
        if(auth::check()){
            notify()->success('you are now signin');
            return redirect()->route('home');  
        }else{
            return view('auth.signin',[
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

                session_start();
                
                $_SESSION['user'] = [
                    'id' => Auth::id(),
                    'user_name' => Auth::user()->user_name,
                    'profile_pic' => Auth::user()->profile_pic,
                ];
                                
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
 
    function signup(){
        if(auth::check()){
            notify()->success('you are now signin');
            return redirect()->route('home');  
        }else{
            return view('auth.signup');
        }
    }

    function logoutPost(Request $request){
        Auth::logout();

        $request->session()->invalidate();
 
        $request->session()->regenerateToken();

        notify()->success('signout user successfully!');

        session_start();
        session_destroy();
         
        return redirect()->route('signin');
    }

    function logoutRoute(){
        return redirect()->route('signin');
    }
    
    public function forgotPassword(){
        if(Auth::check()){
            return redirect()->route('home');
        }else{
            return view('auth.forgotPassword');
        }
    } 

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
