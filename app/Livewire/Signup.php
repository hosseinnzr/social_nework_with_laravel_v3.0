<?php

namespace App\Livewire;

use App\Models\User;
use App\Mail\SendMail;

use Livewire\Component;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;


class Signup extends Component
{

    public $state = 0;
    public $email;
    public $random_number;
    public $send_code = false;


    public $user_name, $first_name, $last_name, $password, $verify_code;


    public function backToZero(){
        $this->state = 0;
    }

    public function checkemail(){
        if(isset($this->email)){

            if((User::where('email', $this->email)->first())){
                return back()->with('error', "Another account is using the same email.");
            }
            

            $this->random_number = mt_rand(123456, 987654);
            if(Mail::to($this->email)->send(new SendMail($this->random_number))){
                $this->send_code = true;
                $this->state = 1;
                return "Email send successfully";
            }
        }

        return 'Email send error';
    }

    public function signup(){

        if ($this->verify_code != $this->random_number) {
            notify()->error('verify code wrong');
            return back()->with('error', "verify code not match");
        }

        $data['first_name'] = $this->first_name;
        $data['last_name'] = $this->last_name;
        $data['user_name'] = $this->user_name;
        $data['email'] = $this->email;
        $data['password'] = Hash::make($this->password);
        $data['profile_pic'] = '/default/default_profile.jpg';
        
        $user = User::create($data);
        if($user){
            notify()->success('signup user successfully!');
            return redirect(route('signin'));
        }
        return redirect()->back();
    }


    public function render()
    {
        return view('livewire.signup',[
            'email' => $this->email
        ]);
    }
}
