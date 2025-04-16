
<div style="width: 100%; padding: 0px"  class="offcanvas-body pt-0 custom-scrollbar">

    <!-- Add comment START -->
    <div class="d-flex mb-2 pt-3">
        <!-- Avatar -->
        <div class="avatar avatar-xs me-2">
            <a href="/user/{{auth()->user()->user_name}}"> <img class="avatar-img rounded-circle" src="{{auth()->user()->profile_pic}}" alt=""> </a>
        </div>

        <!-- Comment box START -->
        <div class="offcanvas-body p-0">
            <div style="position: sticky; top: 500;" class=" rounded-end-lg-0 w-full border-end-lg-0">
                <!-- add comment START -->

                <form wire:submit="save({{$postId}})" >
                    <div class="input-group mb-3">
                        <input wire:model="comment" name="comment" id="cmnt-input" type="text" class="form-control" placeholder="Add a comment…" aria-label="Search">
                        <button class="btn btn-light" id="cmnt-btn" type="submit">  <i class="fa-solid fa-comment"></i></button>
                    </div>
                </form>

            </div>
        </div>
        <!-- Comment box END -->

    </div>
    <!-- Add comment END -->

    <!-- Comment wrap START -->
    <ul class="comment-wrap list-unstyled">

        @foreach ($post_comments as $single_comment)

        <!-- Comment item START -->
        <br>
        <li class="comment-item">
            <div class="d-flex position-relative">
                <!-- Avatar -->
                <div class="avatar avatar-xs">
                <a href="/user/{{$single_comment['user_name']}}"><img class="avatar-img rounded-circle" src="{{asset($single_comment['user_profile'])}}" alt=""></a>
                </div>
                <div class="ms-2">
                    <!-- Comment by -->
                    <div class="ms-2">
                        <div class="bg-light rounded-start-top-0 p-2 rounded">
                            <div class="d-flex justify-content-between">
                            <p class="mb-1"> <a href="/user/{{$single_comment['user_name']}}"> {{$single_comment['user_name']}} </a></p>
                            
                            <div class="d-flex align-items-center justify-content-between">
                                @if ($single_comment['liked'])
                                    <button style="color:red" wire:click="dislike({{$single_comment}})"><i class="bi bi-heart-fill "></i></button>
                                @else
                                    <button wire:click="like({{$single_comment['id']}})"><i class="bi bi-heart "></i></button>
                                @endif

                                @if ($single_comment['UID'] == Auth::id())
                                    <!-- Card share action menu -->
                                    <a href="#" class="text-secondary btn py-0 px-2" id="commentAction{{$single_comment['id']}}" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
    
                                    <!-- Card share action dropdown menu -->    
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="commentAction{{$single_comment['id']}}">
                                        <li><button class="dropdown-item text-danger" wire:click="delete({{$single_comment}})"> <i class="bi bi-bookmark fa-fw pe-2 "></i>delete commnet</button></li>
                                    </ul>                                     
                                @endif
                            </div>    

                            </div>
                            <p style="max-width: 30ch; word-wrap: break-word; overflow-wrap: break-word;" class="small mb-0">
                                {{$single_comment['comment_value']}}
                            </p>
                            
                        </div>
                    </div>

                    <!-- Comment like, replay, time ago -->
                    <ul class="nav px-2 small">

                        <li wire:poll.visible class="nav-item">
                            <div style="text-align: center">
                                <a>{{ $single_comment['like_number'] }} likes</a>
                            </div>
                        </li>

                        <li class="nav-item">
                            <small>&nbsp; &nbsp; Reply</small>
                        </li>

                        <li style="text-align:right" class="nav-item">
                            <small>&nbsp; &nbsp; {{$single_comment['created_at']->diffForHumans()}}</small> 
                        </li>
                    </ul>
                </div>
            </div>
            
        </li>
        <!-- Comment item END -->
        @endforeach

        @if ($show_load_more)
            <br>
            <li wire:click="loadMore()" class="comment-item">
                <div class="d-flex justify-content-center bg-light m-2 rounded">
                    <div>
                        <!-- Load more comments -->
                        <button style="padding:5px 8px 5px 8px; ">Load more ...</button>
                    </div>
                </div>
            </li>
        @endif
    </ul>
    <!-- Comment wrap END -->
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // زمانی که هر dropdown باز میشه
            document.querySelectorAll('.dropdown').forEach(function (dropdown) {
                dropdown.addEventListener('shown.bs.dropdown', function () {
                    // پیدا کردن تمام <li>هایی که wire:poll.visible دارن
                    document.querySelectorAll('li[wire\\:poll\\.visible]').forEach(function (pollingLi) {
                        pollingLi.removeAttribute('wire:poll.visible');
                    });
                });
            });
        });
    </script>
    
    
</div>
