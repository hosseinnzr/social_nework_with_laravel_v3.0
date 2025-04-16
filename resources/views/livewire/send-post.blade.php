<div>
    @if ($notification)
        <p class="alert alert-success">{{$notification}}</p>
    @endif  

    <input class="form-control bg-light" type="search" placeholder="Search user" aria-label="Search user" wire:model.live="search">

    @isset($users)
    <div class="dropdown-menu dropdown-menu-size-md p-0 shadow-lg border-0 show">
        @foreach ($users as $user)

        <div class="col-sm-12 col-lg-12">
            <div class="card" >
            <!-- Card body START -->
            <div style="padding: 12px 10px 0px 10px" class="card-body">
                <!-- Connection item START -->
                <div class="hstack gap-2 mb-3">
                    <!-- Avatar -->
                    <div class="avatar">
                        <a href="{{ route('profile', ['user_name' => $user['user_name']]) }}"><img class="avatar-img rounded-circle" src="{{$user['profile_pic']}}" alt=""></a>
                    </div>
                    <!-- Title -->
                    <div class="overflow-hidden">
                        <a class="h6 mb-0" href="{{ route('profile', ['user_name' => $user['user_name']]) }}" >{{$user['user_name']}}</a>
                        <p class="mb-0 small text-truncate">{{$user['first_name']}} {{$user['last_name']}}</p>
                    </div>
                    <!-- Button -->
                    @if ( in_array($user['id'], $select_user_id) )
                        <button style="font-size: 20px" class="btn rounded-circle icon-md ms-auto" wire:click="deSelectUser({{$user['id']}})">
                            <i class="bi bi-check-circle-fill"></i>
                        </button>
                    @else
                        <button style="font-size: 20px" class="btn rounded-circle icon-md ms-auto" wire:click="selectUser({{$user['id']}})">
                            <i class="bi bi-circle"></i>
                        </button>    
                    @endif

                </div>
                <!-- Connection item END -->
            </div>
            <!-- Card body END -->
            </div>
        </div>
        <!-- Card follow START -->
        @endforeach
    </div>
    @endisset   

    {{-- send botton --}}
    <div style="padding-top: 15px" class="d-grid">
        <button style="border-radius: 33px; padding: 2px" type="submit" class="btn btn-lg btn-primary" wire:click="send({{$postId}})">send</button>
    </div>

    <hr>
    
    <div style="padding: 10px" class="card-body">
      <div class="row g-3">

        {{-- START copy link --}}
        <script>
            function copyContent{{$postId}}() {
                let text = "https://social.thezoom.ir/p/{{$postId}}";

                navigator.clipboard.writeText(text)
                    .then(() => {
                        console.log('Content {{$postId}} copied to clipboard');
                    })
                    .catch(err => {
                        console.error('Failed to copy: ', err);
                    });
            }
        </script>

        <div class="col-3 col-sm-3 col-lg-3 mb-5  d-flex justify-content-around">
            <div class="d-flex align-items-center position-relative">
                <div class="avatar">
                    <!-- Avatar -->
                    <button style="border: 1px solid; padding: 12px; border-radius: 100%" onclick="copyContent{{$postId}}()" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-copy" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
                        </svg>
                    </button>
                    
                    <div class="overflow-hidden mt-2">
                        <p class="mb-0 small text-truncate text-center">copy<br>link</p>
                    </div>  
                </div>
            </div>
        </div>
        {{-- END copy link --}}

        @foreach ($select_user_info as $select)
            <div class="col-3 col-sm-3 col-lg-3 mb-5  d-flex justify-content-around">
                <div class="d-flex align-items-center position-relative">
                    <div class="avatar">
                        <!-- Avatar -->
                        <img style="baorder: 10px" class="avatar-img rounded-circle" href="{{ route('profile', ['user_name' => $select['user_name']]) }}" src="{{$select['profile_pic']}}" alt="">
                        <!-- Title -->
                        <div class="overflow-hidden">
                            <p class="mb-0 small text-truncate text-center">{{$select['user_name']}}</p>
                        </div>  
                        <!-- Duration -->
                        <div class="position-relative text-center bottom-0 d-flex ">
                            <button style="margin-left: 4px" class="btn rounded-circle icon-md" wire:click="deSelectUser({{$select['id']}})">
                                <i style="font-size: 20px;" class="bi bi-check-circle-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

      </div>
    </div>

</div>


