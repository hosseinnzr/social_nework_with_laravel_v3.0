<!-- post, follow, following START -->
<div class="hstack gap-2 gap-xl-3 justify-content-center">
    <!-- User stat item -->
    <div>
        <h6 style="text-align: center" class="mb-0">{{$user['post_number']}}</h6>
        <small>Post</small>
    </div>
    <!-- Divider -->
    <div class="vr"></div>
    <!-- User stat item -->
    <div data-bs-toggle="offcanvas" href="#showFollowers" role="button" aria-controls="offcanvasChat">
        <h6 style="text-align: center" class="mb-0">{{$user['followers_number']}}</h6>
        <small>Followers</small>
    </div>
    <!-- Divider -->
    <div class="vr"></div>
    <!-- User stat item -->
    <div data-bs-toggle="offcanvas" href="#showFollowing" role="button" aria-controls="offcanvasChat">
        <h6 style="text-align: center" class="mb-0">{{$user['following_number']}}</h6>
        <small>Following</small>
    </div>
</div>
<!-- post, follow, following END -->
