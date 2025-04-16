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
    public $conversation_id = "";
    public $notification = "";
    public $select_user_id = [];

    public $select_user_info = [];
    public $result = [];


    public function send(){
        
        $postId = $this->postId;

        foreach($this->select_user_id as $user_id){

            $post_address = Post::findOrFail($postId)->post_picture;

            $find_conversation_sender_id = conversations::where('sender_id' , auth::id())->where('receiver_id' , $user_id)->get();
            $find_conversation_receiver_id = conversations::where('receiver_id' , auth::id())->where('sender_id' , $user_id)->get();

            if( !($find_conversation_sender_id->isEmpty()) ){
                $this->conversation_id = $find_conversation_sender_id[0]->id;

            }elseif( !($find_conversation_receiver_id->isEmpty()) ){
                $this->conversation_id = $find_conversation_receiver_id[0]->id;
            }else{
                $createdConversation = Conversations::create([
                    'sender_id' => auth::id(),
                    'receiver_id' => $user_id,
                ]); 

                $this->conversation_id = $createdConversation[0];
            }

            if($this->conversation_id != ""){
                $createdMessage = messages::create([
                    'conversation_id' => $this->conversation_id,
                    'sender_id' => auth()->id(),
                    'receiver_id' => $user_id,
                    'body' => '/post-picture/'.$post_address,
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
