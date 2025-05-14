@props(['comment', 'post_comments', 'replyingTo'])

@php
    $replies = $post_comments->where('parent_id', $comment['id']);
@endphp

<li class="comment-item" style="transition: all 0.3s ease;" x-data="{ showReplies: false }">
    <div class="d-flex position-relative">
        <!-- Avatar -->
        <div class="avatar avatar-xs">
            <a href="/user/{{ $comment['user_name'] }}">
                <img class="avatar-img rounded-circle" src="{{ asset($comment['user_profile']) }}" alt="">
            </a>
        </div>

        <div class="ms-2">
            <!-- Comment body -->
            <div class="bg-light rounded p-1">
                <div class="d-flex justify-content-between">
                    <p class="mb-1">
                        <a href="/user/{{ $comment['user_name'] }}">{{ $comment['user_name'] }}</a>
                    </p>

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
                                    <i class="bi bi-three-dots"></i>
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

                <p class="small mb-0" style="max-width: 30ch; word-wrap: break-word;">{{ $comment['comment_value'] }}</p>
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
                    <input wire:model="replyComment" type="text" class="form-control form-control-sm" placeholder="reply to {{ $comment['user_name'] }}">
                    <div class="mt-1 d-flex gap-2 p-2">
                        <button wire:click="cancelReply" class="nav-link bg-light py-1 px-2 mb-0">cancel</button>
                        <button wire:click="saveReply" class="nav-link bg-light py-1 px-2 mb-0">reply</button>
                    </div>
                </div>
            @endif

            @if ($replies->count() > 0)
                <div class="my-1" x-data="{ showReplies_{{ $comment['id'] }}: false }" x-init="$watch('showReplies_{{ $comment['id'] }}', value => {})">
                    <button @click="showReplies_{{ $comment['id'] }} = !showReplies_{{ $comment['id'] }}" class="btn btn-link btn-sm p-0">
                        <span x-show="!showReplies_{{ $comment['id'] }}">show replay</span>
                        <span x-show="showReplies_{{ $comment['id'] }}">hide replay</span>
                    </button>

                    <ul x-show="showReplies_{{ $comment['id'] }}" style="padding-left: 10px;" x-transition>
                        @foreach ($replies as $reply)
                            <x-reply-comment :comment="$reply" :post_comments="$post_comments" :replyingTo="$replyingTo" />
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>
</li>
