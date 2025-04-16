<?php

namespace App\Livewire;

use App\Models\User;
use App\Mail\SendMail;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgetPassword extends Component
{

    public $email;

    public $send_code = false;

    public $random_number;

    public $new_password;

    public $confirm_new_password;

    public $verify_code;

    public function sendCode(){

        if(!isset($this->email)){
            return back()->with('error', "email is require");
        }

        if(!(User::where('email', $this->email)->first())){
            return back()->with('error', "email not found");
        }

        $this->random_number = mt_rand(123456, 987654);
        if(Mail::to($this->email)->send(new SendMail($this->random_number))){
            $this->send_code = true;
            return "Email send successfully";
        }

        return 'Email send error';

    }
    
    public function forgotPassword(){
        
        $validated = $this->validate([ 
            'new_password' => 'required|min:4|string',
            'confirm_new_password' => 'required|min:4|string|same:new_password'
        ]);
        
        // The verify code matches
            if ($this->verify_code != $this->random_number) 
            {
                notify()->error('verify code wrong');
                return back()->with('error', "verify code not match");
            }
    
        // Current password and new password same
            if (strcmp($validated['current_password'], $validated['new_password']) == 0) 
            {
                return redirect()->back()->with("error", "New Password cannot be same as your current password.");
            }
    
            $user = User::where('email', $this->email)->first();
            $user->password = Hash::make($validated['new_password']);
            $user->save();
            notify()->success('Password Changed Successfully');
            return redirect('signin');
    }

    public function render()
    {
        return view('livewire.forget-password',[
            'send_code' => $this->send_code,
            'email' => $this->email,
        ]);
    }
}
