<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use App\Models\savePost as save_post;
use Livewire\Component;

class SavePost extends Component
{
    public $post;
    public $saved;

    public function savepost($post){

        if(!save_post::where('UID',auth::id())->where('post_id', $post['id'])->exists())
        {
            save_post::create([
                'UID' => auth::id(),
                'post_id' => $post['id'],
                'user_post_id' => $post['UID']
            ]);
        }

        notify()->success('you are now signin');

        return back();
    }

    public function deleteSave($post){

        $find_save_post = save_post::where('UID',auth::id())->where('post_id', $post['id']);

        $find_save_post->delete();
    }

    public function render()
    {
        if(save_post::where('UID',auth::id())->where('post_id', $this->post['id'])->exists()){
            $this->saved = 1;
        }else{
            $this->saved = 0;
        }
        return view('livewire.save-post');
    }
}
