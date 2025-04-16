<?php

namespace App\Livewire;
use Livewire\Component;
use App\Models\messages;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\conversations;

class ShowUserChat extends Component
{

    public $conversations;

    public $userId;

    public $user_in_chat;
    public $conversation_id;
    public $chat_result;
    public $message;

    public $show_messages;
    public $show_messages_count;

    public $alluser;
    public $alluser_count; 

    public $chat;


    public function save($user_in_chat){

        if($this->message != null){
            $createdMessage = messages::create([
                'conversation_id' => $this->conversation_id,
                'sender_id' => auth()->id(),
                'receiver_id' => $user_in_chat,
                'body' => $this->message
            ]);

            
            if($createdMessage){
                $this->message = '';
            }
        }
        
    }

    public function result($conversation_id){
        $this->conversation_id = $conversation_id;

        if(conversations::findOrFail($conversation_id)->sender_id == auth::id()){
            $user_in_chat = conversations::findOrFail($conversation_id)->receiver_id;
        }else{
            $user_in_chat = conversations::findOrFail($conversation_id)->sender_id;
        }

        $this->user_in_chat = $user_in_chat;

        $this->chat_result = conversations::where('id', $conversation_id)->get();
    }

    public function render()
    {
        if($this->chat != null){
            $this->chat_result = $this->chat;
        }

        $this->show_messages = messages::where('conversation_id', $this->conversation_id)->get();
        $this->show_messages_count = messages::where('conversation_id', $this->conversation_id)->count();

        $this->userId = auth::id();
        $this->conversations = conversations::where('sender_id', $this->userId)->orWhere('receiver_id', $this->userId)->get();

        $this->alluser = User::select('id', 'first_name', 'last_name', 'profile_pic', 'user_name')->get();
        $this->alluser_count = User::select('id', 'first_name', 'last_name', 'profile_pic', 'user_name')->count();

        return view('livewire.chat.show-user-chat');
    }
}
