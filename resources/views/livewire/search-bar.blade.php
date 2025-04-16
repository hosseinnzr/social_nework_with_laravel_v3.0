<form class="rounded position-relative">
    <input class="form-control bg-light" type="search" placeholder="Search" aria-label="Search" wire:model.live="search">
        @isset($users)
        <div class="dropdown-menu dropdown-menu-size-md p-0 shadow-lg border-0 show mt-1">
            @foreach ($users as $user)

            <div class="col-sm-6 col-lg-12">
                <!-- Card body START -->
                <div style="padding: 5px 0px 5px 14px" class="card-body">
                    <!-- Connection item START -->
                    <div class="hstack gap-2 mb-1">
                        <!-- Avatar -->
                        <div class="avatar">
                            <a href="{{ route('profile', ['user_name' => $user['user_name']]) }}"><img class="avatar-img rounded-circle" src="{{$user['profile_pic']}}" alt=""></a>
                        </div>

                        <!-- Title -->
                        <div class="overflow-hidden">
                            <a class="h6 mb-0" href="{{ route('profile', ['user_name' => $user['user_name']]) }}" >{{$user['user_name']}}</a>
                            <p class="mb-0 small text-truncate">{{$user['first_name']}} {{$user['last_name']}}</p>
                        </div>

                    </div>
                    <!-- Connection item END -->
                </div>
                <!-- Card body END -->
            </div>
            <!-- Card follow START -->
            @endforeach

            @foreach ($hashtags as $hashtag)

            <div class="col-sm-6 col-lg-12">
                <!-- Card body START -->
                <div style="padding: 0px 0px 0px 14px" class="card-body">

                    <!-- Connection item START -->
                    <div class="hstack gap-0">
                        <!-- Avatar -->
                        <div class="avatar mt-2">
                            <a class="btn btn-secondary-soft rounded-circle icon-md ms-auto" href="/explore/?tag={{$hashtag['name']}}"><i class="bi bi-hash"></i></a>
                        </div>

                        <div class="container">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <!-- name -->
                                    <a class="mb-0 small text-truncate" href="/explore/?tag={{$hashtag['name']}}">{{$hashtag['name']}}</a>
                                </div>
                                
                                <div>
                                    <!-- number -->
                                    <p class="mb-0 small text-truncate">{{$hashtag['number']}}</p>
                                </div>
                                
                            </div>
                        </div>

                    </div>
                    <!-- Connection item END -->
                </div>
                <!-- Card body END -->
            </div>
            <!-- Card follow START -->
            @endforeach
        </div>
    @endisset                
</form>

