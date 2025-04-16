<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\conversations;
use App\Models\messages;
use App\Models\User;
use Illuminate\Routing\Controller;
use PhpParser\Node\Stmt\Foreach_;
use Symfony\Component\HttpFoundation\File\Exception\FormSizeFileException;

class ChatController extends Controller
{
    public function index(Request $request){
        return view('chat.index', [
            'chat' => null
        ]);
    }
    public function show($query){

        $Id = auth::id();

        $users_in_chat = conversations::where('sender_id', $Id)->orWhere('receiver_id', $Id)->get();

        $users_in_chat_id = [];

        foreach($users_in_chat as $user_in_chat){
            if($user_in_chat->sender_id != $Id){
                array_push($users_in_chat_id, $user_in_chat->sender_id);
            }else{
                array_push($users_in_chat_id, $user_in_chat->receiver_id);
            }
        }

        $users = User::whereIn('id', $users_in_chat_id)->get();

        $chat = messages::where('conversation_id', $query)->get();

        return view('chat.index', [
            'users' => $users,
            'chat' => $chat
        ]);

    }
    public function makaConversation(Request $request)
    {

        if(auth::check()){

            $userId = $request->id;

            $user_in_chat = conversations::where('sender_id', $userId)->orWhere('receiver_id', $userId)->get();

            $authenticatedUserId = auth()->id();
    
            # Check if conversation already exists
            $existingConversation = Conversations::where(function ($query) use ($authenticatedUserId, $userId) {
                    $query->where('sender_id', $authenticatedUserId)
                        ->where('receiver_id', $userId);
                    })
                ->orWhere(function ($query) use ($authenticatedUserId, $userId) {
                    $query->where('sender_id', $userId)
                        ->where('receiver_id', $authenticatedUserId);
                })->first();
            
            if ($existingConversation) {
                # Conversation already exists, redirect to existing conversation
                return redirect()->route('chat', [
                    'query' => $existingConversation->id,
                    'user_in_chat' => $user_in_chat
                ]);
            }
        
            # Create new conversation
            $createdConversation = Conversations::create([
                'sender_id' => $authenticatedUserId,
                'receiver_id' => $userId,
            ]);        

                return redirect()->route('chat', [
                    'query' => $createdConversation->id,
                    'user_in_chat' => $user_in_chat
                ]);

        }
    }

}
