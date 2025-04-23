<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;
use Livewire\Component;
use App\Models\messages;
use App\Models\conversations;

class SendPost extends Component
{
    public $search = "";
    public $postId ;
    public $notification = "";
    public $select_user_id = [];
    public $select_user_info = [];
    public $result = [];


    public function send(){
        
        $postId = $this->postId;

        foreach($this->select_user_id as $user_id){

            $post_info = Post::findOrFail($postId);
            $find_user_name = User::findOrFail($user_id)['user_name'];

            if($post_info->post_picture != null){
                $createdMessage = messages::create([
                    'sender_id' => auth::user()->user_name,
                    'receiver_id' => $find_user_name,
                    'body' => '/post-picture/'.$post_info->post_picture,
                ]);

                if($createdMessage){
                    $this->select_user_info = [];
                    $this->select_user_id = [];

                    $this->notification = 'send massage successfully';
                    
                }
            }else{
                $createdMessage = messages::create([
                    'sender_id' => auth::user()->user_name,
                    'receiver_id' => $find_user_name,
                    'body' => '/post-video/'.$post_info->post_video,
                ]);

                if($createdMessage){
                    $this->select_user_info = [];
                    $this->select_user_id = [];

                    $this->notification = 'send massage successfully';
                    
                }
            }
        }

    }


    public function selectUser($id){
        array_push($this->select_user_id, $id);

        $user_info = user::findOrFail($id);
        array_push($this->select_user_info, $user_info);

        $this->search = "";
    }

    public function deSelectUser($id){
        $this->select_user_id = array_diff($this->select_user_id, array($id));

        $this->select_user_info = [];
        
        foreach($this->select_user_id as $id){
            $user_info = user::findOrFail($id);
            array_push($this->select_user_info, $user_info);
        }
    }

    public function render()
    {

        if(strlen($this->search) >= 2){
            $this->result = User::where('user_name', 'like', '%'.$this->search.'%')->limit(6)->get();
        }else{
            $this->result = [];
        }

        return view('livewire.send-post', [
            'users' => $this->result,
        ]);
    }
}
