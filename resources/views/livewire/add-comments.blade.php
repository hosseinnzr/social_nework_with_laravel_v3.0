
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
    <ul style="transition: all 0.3s ease; padding-left: 0px">
        @foreach ($post_comments->where('parent_id', null) as $comment)
            <x-single-comment :comment="$comment" :post_comments="$post_comments" :replyingTo="$replyingTo" />
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
