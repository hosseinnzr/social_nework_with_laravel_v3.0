@extends('layout')

@section('title', 'Notifications')  

@section('content')
@auth
{{ csrf_field() }}

<main>
  
    <!-- Container START -->
    <div class="container">
      <div class="row g-4">
        <!-- Main content START -->
        <div class="col-lg-12 mx-auto">
          <!-- Card START -->
          <div class="card">
            
            <div class="card-header py-3 border-0 d-flex align-items-center justify-content-between">
              <h1 class="h5 mb-0">Notifications</h1>
              <!-- Notification action START -->
              <div class="dropdown">
                <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardNotiAction" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-three-dots"></i>
                </a>
                <!-- Card share action dropdown menu -->
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardNotiAction">
                  <li><a class="dropdown-item" href="#"> <i class="bi bi-check-all fa-fw pe-2"></i>Mark all read</a></li>
                  {{-- <li><a class="dropdown-item" href="#"> <i class="bi bi-bell-slash fa-fw pe-2"></i>Push notifications </a></li> --}}
                  {{-- <li><a class="dropdown-item" href="#"> <i class="bi bi-bell fa-fw pe-2"></i>Email notifications </a></li> --}}
                </ul>
              </div>
              <!-- Notification action END -->
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

            <div class="card-body p-0" >
                <ul class="list-group list-group-flush list-unstyled p-2">

                    @foreach ($user_notifications as $user_notification)

                        @if ($user_notification->type == 'like')
                            <!-- like post Notif START -->
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
                                                <button class="dropdown-item" wire:click="delete({{$user_notification->id}})"><i class="bi bi-check-all"> </i> Mark as Read</a></button>
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
                            <li class="mb-1">
                              <div 
                              @if ($user_notification['seen'] == 0)
                                class="list-group-item rounded badge-unread d-flex border-0 p-3 justify-content-between"
                              @else
                                class="list-group-item rounded d-flex border-0 p-3 justify-content-between"
                              @endif
                              >
                                    <div class="d-flex align-items-center">
                                        <div style="margin-right:5px" class="avatar text-center d-sm-inline-block">
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
                                                <button class="dropdown-item" wire:click="delete({{$user_notification->id}})"><i class="bi bi-check-all"> </i> Mark as Read</a></button>
                                            </li>        
                                        </ul>
                                    </div>
                                    <!-- Card feed action dropdown END -->
                              </div>
                            </li>
                            <!-- follow Notif END -->
                        @elseif ($user_notification->type == 'follow_request')
                          <!-- follow Notif START -->
                          <li class="mb-1">
                            <div 
                            @if ($user_notification['seen'] == 0)
                              class="list-group-item rounded badge-unread d-flex border-0 p-3 justify-content-between"
                            @else
                              class="list-group-item rounded d-flex border-0 p-3 justify-content-between"
                            @endif
                            >
                                  <div class="d-flex align-items-center">
                                      <div style="margin-right:5px" class="avatar text-center d-sm-inline-block">
                                          <img class="avatar-img rounded-circle" src="{{$user_notification->user_profile}}" alt="">
                                      </div>
                                      <div class="ms-sm-3">
                                          <div>
                                              <div class="nav nav-divider">
                                                  <p class="nav-item card-title mb-0"><b>follow request{{$user_notification->id}}</b></p>
                                                  <span class="nav-item small"> {{$user_notification['created_at']->diffForHumans(null, true, true)}} ago</span>
                                              </div>
                                              <p class="nav-item small"><b>{{$user_notification->body}} </b>&nbsp;send follow request</p>
                                          </div>
                                          
                                          <div class="d-flex">

                                            <form action="{{ route('acceptRequest') }}" method="POST">
                                              @csrf
                                              <input type="hidden" name="userID" value="{{ $user_notification->from }}">
                                              <input type="hidden" name="notificationid" value="{{ $user_notification->id }}">
                                              <button class="btn btn-sm py-1 btn-primary me-2">Accept</button>
                                          </form>
                                          
                                          <form action="{{ route('deleteRequest') }}" method="POST">
                                              @csrf
                                              <input type="hidden" name="userID" value="{{ $user_notification->from }}">
                                              <input type="hidden" name="notificationid" value="{{ $user_notification->id }}">
                                              <button class="btn btn-sm py-1 btn-danger-soft">Delete</button>
                                          </form>
                                          
                                          

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
                                              <button class="dropdown-item" wire:click="delete({{$user_notification->id}})"><i class="bi bi-check-all"> </i> Mark as Read</a></button>
                                          </li>        
                                      </ul>
                                  </div>
                                  <!-- Card feed action dropdown END -->
                            </div>
                          </li>
                          <!-- follow Notif END -->
                        @elseif ($user_notification->type == 'story')
                            <!-- follow Notif START -->
                            <li class="mb-1">
                              <div
                              @if ($user_notification['seen'] == 0)
                                class="list-group-item rounded badge-unread d-flex border-0 p-3 justify-content-between"
                              @else
                                class="list-group-item rounded d-flex border-0 p-3 justify-content-between"
                              @endif
                              >
                                    <div class="d-flex align-items-center">
                                        <div style="margin-right:5px" class="avatar text-center d-sm-inline-block">
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
                                                <button class="dropdown-item" wire:click="delete({{$user_notification->id}})"><i class="bi bi-check-all"> </i> Mark as Read</a></button>
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
                                              <button class="dropdown-item" wire:click="delete({{$user_notification->id}})"><i class="bi bi-check-all"> </i> Mark as Read</a></button>
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

            <div class="card-footer border-0 py-3 text-center position-relative d-grid pt-0">
              <!-- Load more button START -->
              <a href="#!" role="button" class="btn btn-loader btn-primary-soft" data-bs-toggle="button" aria-pressed="true">
                <span class="load-text"> Load more notifications </span>
                <div class="load-icon">
                  <div class="spinner-grow spinner-grow-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                  </div>
                </div>
              </a>
              <!-- Load more button END -->
            </div>
          </div>
          <!-- Card END -->
        </div>
      </div> <!-- Row END -->
    </div>
    <!-- Container END -->
  
</main>

@endauth

@endsection    