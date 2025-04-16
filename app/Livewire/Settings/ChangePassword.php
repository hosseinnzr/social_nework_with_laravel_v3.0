<?php

namespace App\Livewire\Settings;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class ChangePassword extends Component
{

    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function changePassword(){

        $validated = $this->validate([ 
            'current_password' => 'required|string',
            'new_password' => 'required|min:4|string',
            'new_password_confirmation' => 'required|min:4|string|same:new_password'
        ]);
        
        $auth = Auth::user();

        // The passwords matches
            if (!Hash::check($validated['current_password'], $auth->password)) 
            {
                notify()->error('Current Password is Invalid');
                return back()->with('error', "Current Password is Invalid");
            }
    
        // Current password and new password same
            if (strcmp($validated['current_password'], $validated['new_password']) == 0) 
            {
                return redirect()->back()->with("error", "New Password cannot be same as your current password.");
            }
    
            $user =  User::find($auth->id);
            $user->password =  Hash::make($validated['new_password']);
            $user->save();
            return back()->with('success', "Password Changed Successfully");
        }

    public function render()
    {
        return view('livewire.settings.change-password');
    }
}
