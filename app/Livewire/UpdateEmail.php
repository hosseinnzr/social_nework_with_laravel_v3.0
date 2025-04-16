<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class UpdateEmail extends Component
{

    public $email;

    public $send_code = false;

    public $random_number;

    public $verify_code;

    public function sendcode(){

        if(!isset($this->email)){
            return back()->with('error', "email is require");
        }

        if(Auth::user()->email == $this->email){
            return back()->with('error', "Your email is duplicate");
        }
        
        $email_check = User::where('email', $this->email)->get();
        
        if($email_check != "[]"){
            return back()->with('error', "This email has already been used");
        }

        $this->random_number = mt_rand(123456, 987654);
        if(Mail::to($this->email)->send(new SendMail($this->random_number))){
            $this->send_code = true;
            return back()->with('success', "verify code sent successfully");
        }

        return 'Email send error';

    }

    public function emailUpdate(){
        if($this->verify_code == $this->random_number){

            $userId = Auth::id();
            $user =  User::findOrFail($userId);

            $input = [
                'email' => $this->email,
            ];

            $result = $user->update($input);

            if($result){
                notify()->success('update email successfully!');
                return redirect('settings');
            }else{
                return back()->with('error', "update email faild!");
            }
        }else{
            return back()->with('error', "verify code is not correct");
        }
    }

    public function render()
    {
        return view('livewire.update-email');
    }
}
