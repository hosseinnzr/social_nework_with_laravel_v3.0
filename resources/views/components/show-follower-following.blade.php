<!-- Show follower/following START -->
<div class="d-block d-lg-block">
    
    <!-- show follower START -->
    <div class="offcanvas offcanvas-end" data-bs-scroll="false" tabindex="-1" id="showFollowers">
        <!-- Offcanvas header -->
        <div class="offcanvas-header d-flex justify-content-between">
            <h5 class="offcanvas-title">Followers</h5>
            <div class="d-flex">

                <!-- Close  -->
                <a href="#" class="btn btn-secondary-soft-hover py-1 px-2" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
                </a>
        
            </div>
        </div>
        <!-- Offcanvas body START -->

        <div class="offcanvas-body pt-0 custom-scrollbar">
            <ul class="list-unstyled">
            @foreach ( $follower as $single_follower)
            <!-- Contact item -->
            <li class="mt-3 hstack gap-3 align-items-center position-relative toast-btn" data-target="chatToast">
                <!-- Avatar -->
                <div class="avatar">
                <img class="avatar-img rounded-circle" src={{$single_follower['profile_pic']}} alt="">
                </div>
                <!-- Info -->
                <div class="overflow-hidden">
                <a class="h6 mb-0 stretched-link" href="{{ route('profile', ['user_name' => $single_follower['user_name']]) }}">{{$single_follower['user_name']}}</a>
                <div class="small text-secondary text-truncate">{{$single_follower['first_name']}} {{$single_follower['last_name']}}</div>
                </div>
                <!-- Chat time -->
                <div class="small ms-auto text-nowrap"> Just now </div>
            </li>
            @endforeach

            </ul>
        </div>
    </div>
    <!-- show follower END -->

    <!-- show following START -->
    <div class="offcanvas offcanvas-end" data-bs-scroll="false" tabindex="-1" id="showFollowing">
        <!-- Offcanvas header -->
        <div class="offcanvas-header d-flex justify-content-between">
        <h5 class="offcanvas-title">Followings</h5>
            <div class="d-flex">

                <!-- Close  -->
                <a href="#" class="btn btn-secondary-soft-hover py-1 px-2" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
                </a>
        
            </div>
        </div>
        <div class="offcanvas-body pt-0 custom-scrollbar">
            <ul class="list-unstyled">
            @foreach ( $following as $single_following)
            <!-- Contact item -->
            <li class="mt-3 hstack gap-3 align-items-center position-relative toast-btn" data-target="chatToast">
                <!-- Avatar -->
                <div class="avatar">
                <img class="avatar-img rounded-circle" src={{$single_following['profile_pic']}} alt="">
                </div>
                <!-- Info -->
                <div class="overflow-hidden">
                <a class="h6 mb-0 stretched-link" href="{{ route('profile', ['user_name' => $single_following['user_name']]) }}">{{$single_following['user_name']}}</a>
                <div class="small text-secondary text-truncate">{{$single_following['first_name']}} {{$single_following['last_name']}}</div>
                </div>
                <!-- Chat time -->
                <div class="small ms-auto text-nowrap"> Just now </div>
            </li>
            @endforeach
            </ul>
        </div>
    <!-- show following END -->

</div>
<!-- Show follower/following END -->