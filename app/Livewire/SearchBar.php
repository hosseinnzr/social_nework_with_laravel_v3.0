<?php

namespace App\Livewire;

use App\Models\hashtag;
use App\Models\Post;
use App\Models\User;
use Livewire\Component;

class SearchBar extends Component
{

    public $search = "";

    public function render()
    {
        $user_result = [];
        $hashtag_result = [];

        if(str_contains($this->search, '#')){
            $new_search = str_replace('#', '', $this->search);
            
            if(strlen($this->search) >= 3){
                $hashtag_result = hashtag::where('number','>=', '1')->where('name', 'like', '%'.$new_search.'%')->get();
            }
        }else{
            if(strlen($this->search) >= 2){
                $user_result = User::where('status', 'active')->where('user_name', 'like', '%'.$this->search.'%')->limit(6)->get();
            }
        }

        return view('livewire.search-bar', [
            'users' => $user_result,
            'hashtags' => $hashtag_result
        ]);
    }
}
