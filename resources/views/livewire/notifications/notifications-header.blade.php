<div>
    <div class="card" wire:poll.visible>
    <div class="card-header d-flex justify-content-between align-items-center p-3">
        {{-- <h6 class="m-0">Notifications <span class="badge bg-danger bg-opacity-10 text-danger ms-2">new</span></h6> --}}
        <h6 class="m-0">Notifications</h6>
        <a class="small" href="/notifications">See All</a>
        
    </div>

    
        @if ($user_notifications == '[]')
            <div class="card-body p-0" >
                <ul class="list-group list-group-flush list-unstyled p-2">
                    <li>
                        <div class="list-group-item rounded bd-flex border-0 mb-1 p-3 ">
                            <div style="text-align: center;">
                                <h3 class="small mb-2">No notifications</h3>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        @else

            <div style="height: 420px; overflow-y: auto;" class="card-body p-0" >
                <ul class="list-group list-group-flush list-unstyled p-2">

                    @foreach ($user_notifications as $user_notification)
                    
                        @if ($user_notification->type == 'like')
                            <!-- like post Notif START -->
                            <li>
                                <div style="background-color: rgba(97, 97, 97, 0.088)" class="list-group-item rounded d-flex border-0 mb-1 p-3 justify-content-between">

                                    <div class="d-flex align-items-center">
                                        <!-- Avatar -->
                                        <div class="avatar me-2 d-none d-sm-inline-block">
                                        <a href="#!"> <img class="avatar-img rounded-circle" src="{{$user_notification->user_profile}}" alt=""> </a>
                                        </div>

                                        
                                        <!-- Info -->
                                        <div>
                                        <div class="nav nav-divider">
                                            <p class="nav-item card-title mb-0"><b>new like</b></p>
                                            <span class="nav-item small"> {{$user_notification['created_at']->diffForHumans(null, true, true)}} ago</span>
                                        </div>
                                        <p class="mb-0 small">{{$user_notification->body}} like your post</p>
                                        </div>
                                    </div>

                                    <!-- Card feed action dropdown START -->
                                    <div class="dropdown">
                                        <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardFeedAction" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </a>
                                        <!-- Card feed action dropdown menu -->
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardFeedAction">
                                            <li>        
                                                <button class="dropdown-item" wire:click="delete({{$user_notification->id}})"><i class="bi bi-eye-slash"> </i> Hide this notification</a></button>
                                            </li>
                                            <li><a class="dropdown-item" href="{{$user_notification->url}}"> <i class="bi bi-file-post-fill"></i> view post</a></li>
                                        </ul>
                                    </div>
                                    <!-- Card feed action dropdown END -->

                                </div>
                            </li>
                            <!-- like post Notif END -->
                        @elseif ($user_notification->type == 'follow')
                            <!-- follow Notif START -->
                            <li>
                                <div style="background-color: rgba(97, 97, 97, 0.088)" class="list-group-item rounded d-flex border-0 mb-1 p-3 justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar text-center d-none d-sm-inline-block">
                                            <img class="avatar-img rounded-circle" src="{{$user_notification->user_profile}}" alt="">
                                        </div>
                                        <div class="ms-sm-3">
                                            <div>
                                                <div class="nav nav-divider">
                                                    <p class="nav-item card-title mb-0"><b>follow</b></p>
                                                    <span class="nav-item small"> {{$user_notification['created_at']->diffForHumans(null, true, true)}} ago</span>
                                                </div>
                                                <p class="nav-item small"><b>{{$user_notification->body}} </b>&nbsp;follow you</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Card feed action dropdown START -->
                                    <div class="dropdown">
                                        <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardFeedAction" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </a>
                                        <!-- Card feed action dropdown menu -->
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardFeedAction">
                                            <li>        
                                                <button class="dropdown-item" wire:click="delete({{$user_notification->id}})"><i class="bi bi-eye-slash"> </i> Hide this notification</a></button>
                                            </li>        
                                        </ul>
                                    </div>
                                    <!-- Card feed action dropdown END -->

                                </div>
                            </li>
                            <!-- follow Notif END -->
                        @elseif ($user_notification->type == 'follow_request')
                            <!-- follow Notif START -->
                            <li>
                                <div style="background-color: rgba(97, 97, 97, 0.088)" class="list-group-item rounded d-flex border-0 mb-1 p-3 justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar text-center d-none d-sm-inline-block">
                                            <img class="avatar-img rounded-circle" src="{{$user_notification->user_profile}}" alt="">
                                        </div>
                                        <div class="ms-sm-3">
                                            <div>
                                                <div class="nav nav-divider">
                                                    <p class="nav-item card-title mb-0"><b>follow request</b></p>
                                                    <span class="nav-item small"> {{$user_notification['created_at']->diffForHumans(null, true, true)}} ago</span>
                                                </div>
                                                <p class="nav-item small"><b>{{$user_notification->body}} </b>&nbsp;send follow request</p>
                                            </div>
                                            
                                            <div class="d-flex">
                                                <button wire:click="acceptRequest({{$user_notification->id}}, '{{$user_notification->from}}')" 
                                                    class="btn btn-sm py-1 btn-primary me-2">
                                                    Accept
                                                </button>
                                                

                                              <button wire:click="deleteRequest({{$user_notification->id}}, '{{$user_notification->from}}')" 
                                                class="btn btn-sm py-1 btn-danger-soft">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Card feed action dropdown START -->
                                    <div class="dropdown">
                                        <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardFeedAction" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </a>
                                        <!-- Card feed action dropdown menu -->
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardFeedAction">
                                            <li>        
                                            <button class="dropdown-item" wire:click="acceptRequest({{$user_notification->id}}, {{$user_notification->id}})"><i class="bi bi-eye-slash"> </i> Hide this notification</a></button>
                                            </li>        
                                        </ul>
                                    </div>
                                    <!-- Card feed action dropdown END -->

                                </div>
                            </li>
                            <!-- follow Notif END -->
                        @elseif ($user_notification->type == 'story')
                            <!-- follow Notif START -->
                            <li>
                                <div style="background-color: rgba(97, 97, 97, 0.088)" class="list-group-item rounded d-flex border-0 mb-1 p-3 justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar text-center d-none d-sm-inline-block">
                                            <img class="avatar-img rounded-circle" src="{{$user_notification->user_profile}}" alt="">
                                        </div>
                                        <div class="ms-sm-3">
                                            <div>
                                                <div class="nav nav-divider">
                                                    <p class="nav-item card-title mb-0"><b>new like story</b></p>
                                                    <span class="nav-item small"> {{$user_notification['created_at']->diffForHumans(null, true, true)}} ago</span>
                                                </div>
                                                <p class="nav-item small"><b>{{$user_notification->body}} </b>&nbsp;like your story</p>
                                            </div>
                                            
                                            <div class="d-flex">
                                                <a href="http://127.0.0.1:8000/story?user={{auth()->user()->user_name}}" class="btn btn-sm py-1 btn-primary me-2">view story</a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Card feed action dropdown START -->
                                    <div class="dropdown">
                                        <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardFeedAction" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </a>
                                        <!-- Card feed action dropdown menu -->
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardFeedAction">
                                            <li>        
                                                <button class="dropdown-item" wire:click="delete({{$user_notification->id}})"><i class="bi bi-eye-slash"> </i> Hide this notification</a></button>
                                            </li>        
                                        </ul>
                                    </div>
                                    <!-- Card feed action dropdown END -->

                                </div>
                            </li>
                            <!-- follow Notif END -->
                        @elseif ($user_notification->type == 'comment')
                            <!-- comment notifications START -->
                          <li class="mb-1">
                            <div
                            @if ($user_notification['seen'] == 0)
                              class="list-group-item rounded badge-unread d-flex border-0 p-3 justify-content-between"
                            @else
                              class="list-group-item rounded d-flex border-0 p-3 justify-content-between"
                            @endif
                            >
                                  <div class="d-flex align-items-center">
                                      <!-- Avatar -->
                                      <div class="avatar me-2 d-sm-inline-block">
                                      <a href="#!"> <img class="avatar-img rounded-circle" src="{{$user_notification->user_profile}}" alt=""> </a>
                                      </div>

                                      
                                      <!-- Info -->
                                      <div>
                                      <div class="nav nav-divider">
                                          <p class="nav-item card-title mb-0"><b>new comment</b></p>
                                          <span class="nav-item small"> {{$user_notification['created_at']->diffForHumans(null, true, true)}} ago</span>
                                      </div>
                                      <p class="mb-0 small">{{$user_notification->body}} like your post</p>
                                      </div>
                                  </div>

                                  <!-- Card feed action dropdown START -->
                                  <div class="dropdown">
                                      <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardFeedAction" data-bs-toggle="dropdown" aria-expanded="false">
                                          <i class="bi bi-three-dots"></i>
                                      </a>
                                      <!-- Card feed action dropdown menu -->
                                      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardFeedAction">
                                          <li>        
                                              <button class="dropdown-item" wire:click="delete({{$user_notification->id}})"><i class="bi bi-check-all"> </i> Mard as Read</a></button>
                                          </li>
                                          <li><a class="dropdown-item" href="{{$user_notification->url}}"> <i class="bi bi-file-post-fill"></i> view post</a></li>
                                      </ul>
                                  </div>
                                  <!-- Card feed action dropdown END -->

                            </div>
                          </li>
                          <!-- comment notifications END -->
                        @endif

                    @endforeach

                </ul>
            </div>

        @endif
    </div>
</div>
