@props(['comment', 'post_comments', 'replyingTo'])

<li style="transition: all 0.3s ease;">
    <div class="ms-0">
        <!-- Comment body -->
        <div class="bg-light rounded p-1">
            <div class="d-flex justify-content-between">
                <div class="d-flex justify-content-between">
                    <!-- Avatar -->
                    <div class="avatar avatar-xxs">
                        <a href="/user/{{ $comment['user_name'] }}">
                            <img class="avatar-img rounded-circle" src="{{ asset($comment['user_profile']) }}" alt="">
                        </a>
                    </div>
                                        
                    <p class="mb-1" style="margin-left: 0.5rem">
                        <a href="/user/{{ $comment['user_name'] }}">{{ $comment['user_name'] }}</a>
                    </p>    
                </div>


                <div class="d-flex align-items-center">
                    <div style="margin-right: 6px">
                        @if ($comment['liked'])
                            <button style="color:red" wire:click="dislike({{ $comment['id'] }})"><i class="bi bi-heart-fill"></i></button>
                        @else
                            <button wire:click="like({{ $comment['id'] }})"><i class="bi bi-heart"></i></button>
                        @endif
                    </div>

                    @if ($comment['UID'] == Auth::id())
                        <div class="dropdown">
                            <a href="#" class="text-secondary btn p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots" style="margin-left: 8px"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button class="dropdown-item text-danger" wire:click="delete({{ $comment['id'] }})">delete</button>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            @php
                use App\Models\Comments;
                $parent_user_id = Comments::where('id', $comment['parent_id'])->value('UID');

                use App\Models\User;
                $parent_user_name = User::where('id', $parent_user_id)->value('user_name');
            @endphp

            <p class="small mb-0" style="max-width: 30ch; word-wrap: break-word;">
                <a href="/user/{{$parent_user_name}}" style="color: rgb(23, 139, 0)">{{ '@' .$parent_user_name}}</a> {{$comment['comment_value']}}</p>
        </div>

        <ul class="nav small mt-1">
            <li class="nav-item">{{ $comment['like_number'] }} like</li>
            <li class="nav-item ms-3">
                <button wire:click="startReply({{ $comment['id'] }})" class="btn btn-sm p-0">reply</button>
            </li>
            <li class="nav-item ms-3">
                <small>{{ $comment['created_at']->diffForHumans() }}</small>
            </li>
        </ul>

        @if ($replyingTo == $comment['id'])
            <div class="mt-2">
                <input wire:model="replyComment" type="text" value="sss" class="form-control form-control-sm" placeholder="reply to {{$comment['user_name']}}">
                <div class="mt-1 mb-1 d-flex gap-2 p-1">
                    <button wire:click="cancelReply" class="nav-link bg-light py-1 px-2 mb-0">cancel</button>
                    <button wire:click="saveReply" class="nav-link bg-light py-1 px-2 mb-0">reply</button>
                </div>
            </div>
        @endif

        <!-- Child comments (replies) -->
        @php
            $replies = $post_comments->where('parent_id', $comment['id']);
        @endphp

        @if ($replies->count() > 0)
            <ul style="margin-left: 0px; padding-left: 0px;">
                @foreach ($replies as $reply)
                    <x-reply-comment :comment="$reply" :post_comments="$post_comments" :replyingTo="$replyingTo" />
                @endforeach
            </ul>
        @endif
    </div>
</li>
