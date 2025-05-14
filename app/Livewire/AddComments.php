<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\comments;
use App\Models\User;
use App\Models\likeComment;
use App\Models\notifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\notifications\Comment as commentNotifications;


class AddComments extends Component
{

    public $comment;

    public $postId;

    public $post;

    public $post_comments;

    public $single_comment;

    public $error;

    public $show_load_more = true;

    public $comment_number = 0;

    public $parentId = null;
    public $replyingTo = null;
    public $replyComment = '';

    public function startReply($commentId){
        $this->replyingTo = $commentId;
    }

    public function cancelReply(){
        $this->replyingTo = null;
        $this->replyComment = '';
    }

    public function saveReply(){
        comments::create([
            'UID' => Auth::id(),
            'post_id' => $this->postId,
            'comment_value' => $this->replyComment,
            'parent_id' => $this->replyingTo,
            'like' => 0,
            'like_number' => 0,
        ]);

        // send reply notification

        $this->replyingTo = null;
        $this->replyComment = '';
    }

    public function save($postId){
        $input = [
            'UID' => Auth::id(),
            'post_id' => $postId,
            'comment_value' => $this->comment,
            'like' => '0',
            'like_number' => '0',
            'parent_id' => $this->parentId,
        ];

        if($input['comment_value'] != null){
            Comments::create($input);

            // send notifiction
            notifications::create([
                'from' => auth::id(),
                'to' => $this->post['UID'],
                'body' => $this->comment,
                'type'=> 'comment',
            ]);

            // send email
            $user = User::findOrFail($this->post['UID']);
            if($user->comment_notification == 1 && auth::id() != $this->post['UID']){
                $userName = Auth::user();
                Mail::to($user->email)
                ->send(new commentNotifications(
                    $userName['user_name'], 
                    $this->comment, 
                    $this->post['UID']
                ));
            }
        }

        $this->comment = '';
        $this->parentId = null;
    }
    
    public function like($comment_id){
        if(!likeComment::where('UID',auth::id())->where('comment_id', $comment_id)->exists())
        {
            $check = likeComment::create([
                'UID' => auth::id(),
                'comment_id' => $comment_id,
                // 'type'=> 'like',
            ]);

            if(!$check){
                // error
            }
        }

    }

    public function dislike($comment_id){
        $find_like_post = likeComment::where('UID',auth::id())->where('comment_id', $comment_id);

        $check = $find_like_post->delete();

        if(!$check){
            // error
        }
    }

    public function delete($comment_id){
        $find_comment = Comments::findOrFail($comment_id);

        $check = $find_comment->update(['isDeleted' => 1]);

        if(!$check){
            // error
        }
    }

    public function render(){
        $this->post_comments = comments::latest()->where('post_id', $this->postId)->where('isDeleted', 0)->get();

        // check liked
        foreach($this->post_comments as $single_comment){
            if(likeComment::where('UID',auth::id())->where('comment_id', $single_comment['id'])->exists()){
                $single_comment['liked'] = true;
            }else{
                $single_comment['liked'] = false;
            }

            $user = User::findOrFail($single_comment['UID']);

            $single_comment['user_name'] = $user['user_name'];
            $single_comment['user_profile'] = $user['profile_pic'];

            $single_comment['like_number'] = likeComment::where('comment_id', $single_comment['id'])->count();
        }

        return view('livewire.add-comments',[
            'post_comments' => $this->post_comments,
        ]);
    }
}
