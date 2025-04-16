@extends('layout')
@if (isset($hash_tag))
  @section('title', "home - #$hash_tag")
@else
  @section('title', 'home')  
@endif

@section('content')
@auth
{{ csrf_field() }}


<main>      
  <!-- Container START -->
  <div class="container">
    <!-- Row START -->
    <div class="row g-4">

      <!-- Left sidebar START -->
      <div style="position: -webkit-sticky; position: sticky; overflow-y: auto; z-index: 999; padding-left: 0px" class="col-lg-3">

        <!-- Advanced filter responsive toggler START -->
        <div class="d-flex align-items-center d-lg-none">
          <button style="background-color: rgba(255, 174, 0, 0.763); border-radius: 0px 33px 33px 0px" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSideNavbar" aria-controls="offcanvasSideNavbar">
            <i style="color: rgb(255, 255, 255)" class="btn fw-bold bi bi-person-fill"></i>
          </button>
        </div>
        <!-- Advanced filter responsive toggler END -->
        
        <!-- Navbar START-->
        <nav class="navbar navbar-expand-lg mx-0"> 
          <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSideNavbar">
            <!-- Offcanvas header -->
            <div class="offcanvas-header">
              <button type="button" class="btn-close text-reset ms-auto" data-bs-dismiss="offcanvas" aria-label="Close" aria-atomic="flase" data-bs-autohide="false"></button>
            </div>

            <!-- Offcanvas body -->
            <div class="offcanvas-body d-block px-0 px-lg-0">
              <!-- Card START -->
              <div style="border: 0px;" class="card overflow-hidden">
                <!-- Cover image -->
                <div class="h-50px" style="background-image:url(assets/images/bg/01.jpg); background-position: center; background-size: cover; background-repeat: no-repeat;"></div>
                  <!-- Card body START -->
                  <div class="card-body pt-0">
                    <div class="text-center">
                    <!-- Avatar -->
                    <div class="avatar avatar-xl mt-n5 mb-3">
                      <a href="#!"><img class="avatar-img rounded border border-white border-3" src="{{auth()->user()->profile_pic}}" alt=""></a>
                    </div>

                    <!-- Info -->
                    <h5 class="mb-0"> <a href="/user/{{auth()->user()->user_name}}">{{auth()->user()->first_name}} {{auth()->user()->last_name}}</a> </h5>
                    <small>{{auth()->user()->email}}</small>
                    <p class="mt-3">{{auth()->user()->biography}}</p>

                    <!-- post, follow, following START -->
                      <x-post-follower-following :user="auth()->user()"/>
                    <!-- post, follow, following END -->

                    </div>

                    <!-- Divider -->
                    <hr>

                    <!-- Side Nav START -->
                    <ul class="nav nav-link-secondary flex-column fw-bold gap-0">
                      <li class="nav-item">
                        <div class=" text-center py-0">
                          <a class="btn btn-link text-secondary btn-sm" type="submit" href="{{ route('profile', ['user_name' => Auth::user()->user_name]) }}">view Profile </a>
                        </div>
                      </li>

                    </ul>
                  <!-- Side Nav END -->
                </div>
                <!-- Card body END -->
              </div>
              <!-- Card END -->
            </div>
          </div>
        </nav>
        <!-- Navbar END-->
      </div>
      <!-- Left sidebar END -->

      <!-- Main content START -->
      <div style="padding: 0px" class="col-md-8 col-lg-6 vstack gap-2">

          <!-- Story START -->
          <div class="tiny-slider arrow-hover overflow-hidden">

            <div class="tiny-slider-inner d-flex" data-arrow="true" data-dots="true" data-loop="false" data-autoplay="false" data-items-xl="6" data-items-lg="5" data-items-md="5" data-items-sm="5" data-items-xs="3" data-gutter="12" data-edge="30">


              <!-- Add Story -->
              <div class="position-relative text-center">
                <!-- Card START -->
                <div>
                  <a style="margin-bottom: 7px" class="stretched-link btn btn-dark rounded-circle icon-xl rounded-circle" data-bs-toggle="modal" data-bs-target="#postStory"><i class="fa-solid fa-plus fs-6"></i></a>
                </div>
                <div>
                  <a class="small fw-normal text-secondary">Add story</a>
                </div>
                <!-- Card END -->
              </div>
              @if (isset($storys))
                @foreach ($storys as $story)
                  <div style="padding: 0%" class="position-relative text-center">
                    <div style="padding: 3px; background: linear-gradient(220deg, #2f4bd2, #ac3ec3, #ea4147, #eaba41, #ffd06a); border-radius: 50%" class="avatar avatar-lg">
                      <a href="/story?user={{$story['user_name']}}"><img class="avatar-img rounded-circle" src="{{$story['user_profile_pic']}}" alt=""></a>
                    </div>
                    <div>
                      <a href="/story?user={{$story['user_name']}}" class="stretched-link small fw-normal text-secondary">{{$story['user_name']}}</a>
                    </div>
                  </div>
                @endforeach
              @endif

            </div>
          </div>
          <!-- Story END -->

        <!-- Show hashtag START -->
        @if (isset($hash_tag))
          <div class="card card-body">
            <ul class="nav nav-pills nav-stack small fw-normal">
              <li class="nav-item">
                <a class="nav-link bg-light py-1 px-2 mb-0" data-bs-toggle="modal" data-bs-target="#feedActionPhoto"> <i class="bi bi-hash text-success pe-1"></i>{{$hash_tag}}</a>
              </li>
            </ul>
          </div>
        @endif
        <!-- Show hashtag END -->

        @if ($posts != '[]')
          <!-- Card feed item START -->
          @foreach ($posts as $post)

            <script>
              document.addEventListener('DOMContentLoaded', (event) => {
                var modal = document.getElementById("myModal{{$post['id']}}");
                var btn = document.getElementById("myBtn{{$post['id']}}");
                var span = modal.querySelector(".close");

                btn.onclick = function() {
                  modal.style.display = "block";
                }

                span.onclick = function() {
                  modal.style.display = "none";
                }

                document.onclick = function(event) {
                  if (event.target == modal) {
                    modal.style.display = "none";
                  }
                }
              });
            </script>

            <div class="card">
              <!-- Card header START -->
              <div class="card-header">
                  <div class="d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center">
                      <!-- Avatar -->
                      <div class="avatar me-2">
                      <a href="#!"> <img class="avatar-img rounded-circle" src="{{$post['user_profile_pic']}}" alt="user_img"> </a>
                      </div>
                      <!-- Info -->
                      <div>
                      <h6 class="card-title mb-0"> <a href="/user/{{$post['user_name']}}">  {{$post['user_name']}}   </a></h6>
                      <p class="small mb-0">{{$post['created_at']->diffForHumans()}}</p>
                      </div>
                  </div>
                  <!-- Card share action START -->
                  <div class="dropdown">
                      <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardShareAction8" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-three-dots"></i>
                      </a>
                      <!-- Card share action dropdown menu -->
                      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardShareAction8">
                        <li>                                
                          {{-- <form action="{{route('follow', ['id' => $post['UID']])}}" method="POST" class="ms-auto me-auto">
                            @csrf
                            <button type="submit" class="dropdown-item"><i class="bi bi-person-x fa-fw pe-2"></i>unfollow {{$post['user_name']}}</button>
                          </form> --}}
                        </li>
                        <li><a class="dropdown-item" href="#"> <i class="bi bi-slash-circle fa-fw pe-2"></i>Block {{$post['user_name']}}</a></li>
                        <li><a class="dropdown-item" href="/p/{{$post['id']}}"> <i class="bi bi-file-post-fill"></i> view post</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"> <i class="bi bi-flag fa-fw pe-2"></i>Report post</a></li>
                      </ul>
                  </div>
                  <!-- Card share action START -->
                  </div>
              </div>
              <!-- Card header START -->
              
              <!-- Card body START -->
              <div class="card-body">
                  @isset($post['post_picture'])
                    <img class="card-img" src="/post-picture/{{$post['post_picture']}}" alt="Post">
                    <br>    
                  @endisset 

                  @isset($post['post_video'])
                    <div class="card-image">
                      <div class="overflow-hidden fullscreen-video w-100">
                        <!-- HTML video START -->
                        <div class="player-wrapper card-img-top overflow-hidden">
                          <video class="player-html" controls poster="assets/images/videos/poster.jpg">
                          {{-- <video class="player-html" controls> --}}
                            <source src="/post-video/{{ $post['post_video'] }}" type="video/mp4">
                          </video>
                        </div>
                        <!-- HTML video END -->
                      </div>
                    </div>
                  @endisset

                  <p class="mb-0">{{$post['post']}}</p>
                  
                  @foreach(explode(",", $post['tag']) as $tag)
                    @if ($tag != '')
                      <a href="/explore/?tag={{str_replace('#', '', $tag)}}">#{{$tag}} </a>
                    @endif
                  @endforeach
              </div>
              <!-- Card body END -->
      
              <!-- Card Footer START -->
              <div class="card-footer py-3"> 
                  <!-- Feed react START -->
                <ul class="nav nav-fill nav-stack small">

                  <li class="nav-item">
                    @livewire('like-post', ['post' => $post])
                  </li>

                  <li class="nav-item">
                    <div data-bs-toggle="modal" data-bs-target="#showComments{{$post['id']}}" aria-controls="offcanvasChat">
                      <small style="text-align: center" class="mb-0"> <i class="bi bi-chat fa-xl pe-1"></i></small>
                    </div>
                  </li>
                
                  <!-- scroll show comment START -->
                  <div class="modal fade" id="showComments{{$post['id']}}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                      <div class="modal-content">

                        <!-- Modal feed header START -->
                        <div class="modal-header">
                          <h6 class="modal-title">Comments </h6>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Modal feed header END -->

                        <!-- show post START -->
                          <div class="card-body">
                            <div class="row g-3">

                              <div class="col-12 col-lg-6">
                                @isset($post['post_picture'])
                                <img class="card-img" src="/post-picture/{{$post['post_picture']}}" alt="Post">
                                @endisset 
                                <br>
                                <ul class="nav nav-fill nav-stack small">
                                  <li class="nav-item">
                                    @livewire('like-post', ['post' => $post])
                                  </li>

                                  <button id="myBtn{{$post['id']}}"><i class="bi bi-send fa-xl pe-1"></i></button>
                                  <div id="myModal{{$post['id']}}" class="modal" style="z-index: 1401;">
                                    <div class="modal-content-send-post">
                                      <!-- show post START -->
                                      <div class="card">
                                        <span class="close modal-header">&times;</span>
                                        <div style="padding: 15px;" class="row g-3">
                                          <div class="col-12 col-lg-12">
                                            <div class="sends-container" style="height: 420px; overflow-y: auto;">
                                              <!-- Nav Search START -->
                                              @livewire('send-post', ['postId' => $post['id']])
                                              <!-- Nav Search END -->
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- show post END -->
                                    </div>
                                  </div>
        
                                  <li class="nav-item">
                                    @livewire('save-post', ['post' => $post]) 
                                  </li>

                                </ul>

                              </div>

                              <div class="col-12 col-lg-6">

                                <div class="comments-container" style="height: 420px; overflow-y: auto;">
                                  <p style="width: 100%;" class="mb-0">{{$post['post']}}</p>
                                  <br>
                                  @livewire('add-comments', ['postId' => $post['id'], 'post' => $post])
                                </div>

                              </div>

                            </div>
                          </div>
                        <!-- show post END -->

                      </div>
                    </div>
                  </div>
                  <!-- scroll show comment END -->

                  <!-- send button START -->
                  <li class="nav-item">
                    <div data-bs-toggle="modal" data-bs-target="#showSend{{$post['id']}}" aria-controls="offcanvasChat">
                      <small style="text-align: center" class="mb-0"> <i class="bi bi-send fa-xl pe-1"></i></small>
                    </div>
                  </li>

                    <!-- scroll show send START -->
                    <div class="modal fade" id="showSend{{$post['id']}}" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                          <!-- Modal feed header START -->
                          <div class="modal-header">
                            <h6 class="modal-title">send post to </h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <!-- Modal feed header END -->

                          <!-- show post START -->
                            <div style="padding: 10px" class="card-body">
                              <div class="row g-3">

                                <div class="col-12 col-lg-12">
                                  <div class="sends-container" style="height: 420px; overflow-y: auto;">
                                    
                                    <!-- Nav Search START -->
                                    @livewire('send-post', ['postId' => $post['id']])
                                    <!-- Nav Search END -->
                                  </div>
                                </div>

                              </div>
                            </div>
                          <!-- show post END -->

                        </div>
                      </div>
                    </div>
                    <!-- scroll show send END -->

                  <!-- send button END -->

                  <li class="nav-item">
                    @livewire('save-post', ['post' => $post]) 
                  </li>

                </ul>
                  <!-- Feed react END -->
              </div>
              <!-- Card Footer END -->
      
            </div>

          @endforeach
          <!-- Card feed item END -->    
        @else    
          <!-- Card feed item START -->
          <div class="card">
            <!-- Card header START -->
            <div class="card-header d-flex justify-content-between align-items-center border-0 pb-0">
              <h6 class="card-title mb-0">People you may know</h6>
              <button class="btn btn-sm btn-primary-soft"> See more </button>
            </div>      
            <!-- Card header START -->
  
            <!-- Card body START -->
            <div class="card-body">
              <div class="tiny-slider arrow-hover">
                <div class="tiny-slider-inner ms-n4" data-arrow="true" data-dots="false" data-items-xl="3" data-items-lg="2" data-items-md="2" data-items-sm="2" data-items-xs="1" data-gutter="12" data-edge="30">
                  
                  <!-- Slider items -->
                  @foreach ($new_users as $new_user)
                    <div> 
                      <!-- Card add friend item START -->
                      <div class="card shadow-none text-center">
                        <!-- Card body -->
                        <div class="card-body p-2 pb-0">
                          <div class="avatar avatar-xl">
                            <a href="/user/{{$new_user->user_name}}"><img class="avatar-img rounded-circle" src="{{$new_user->profile_pic}}" alt=""></a>
                          </div>
                          <h6 class="card-title mb-1 mt-3"> <a href="/user/{{$new_user->user_name}}">{{$new_user->user_name}}</a></h6>
                          <p class="mb-0 small lh-sm">{{$new_user->first_name}} </br> {{$new_user->last_name}}</p>
                        </div>
                        <!-- Card footer -->
                        <div class="card-footer p-2 border-0">
                          <button class="btn btn-sm btn-primary-soft w-100"> follow </button>
                        </div>
                      </div>
                      <!-- Card add friend item END -->
                    </div>
                  @endforeach
                  
                </div>
              </div>
            </div>
            <!-- Card body END -->
          </div>
          <!-- Card feed item END -->
        @endif


        <br>

      </div>
      <!-- Main content END -->

      <!-- Right sidebar START -->
      <div class="col-lg-3 d-none d-lg-block">
        <div class="row g-4">
          <!-- New Users START -->
          <div class="col-sm-6 col-lg-12">
            <div style="border: 0px;"  class="card">
              <!-- Card header START -->
              <div class="card-header pb-0 border-0">
                <h5 class="card-title mb-0">New Users</h5>
              </div>
              <!-- Card header END -->

              <!-- Card body START -->
              <div class="card-body">

                <!-- Connection item START -->
                @foreach ($new_users as $new_user)
                  <div class="hstack gap-2 mb-3">
                    <!-- Avatar -->
                    <div class="avatar">
                      <a href="/user/{{$new_user->user_name}}"><img class="avatar-img rounded-circle" src="{{$new_user->profile_pic}}" alt=""></a>
                    </div>
                    <!-- Title -->
                    <div class="overflow-hidden">
                      <a class="h6 mb-0" href="/user/{{$new_user->user_name}}" >{{$new_user->user_name}}</a>
                      <p class="mb-0 small text-truncate">{{$new_user->first_name}} {{$new_user->last_name}}</p>
                    </div>
                    <!-- Button -->
                    <a class="btn btn-primary-soft rounded-circle icon-md ms-auto" href="/user/{{$new_user->user_name}}" ><i class="fa-solid fa-plus"> </i></a>
                  </div>
                @endforeach
                <!-- Connection item END -->

              </div>
              <!-- Card body END -->

            </div>
          </div>
          <!-- New Users START -->

          <!-- Helper link START -->
          <ul class="nav small mt-4 justify-content-center lh-1">
            <li class="nav-item">
              <a class="nav-link" target="_blank" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" target="_blank" href="/settings">Settings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" target="_blank" href="#">Support </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" target="_blank" href="#">Docs </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" target="_blank" href="#">Help</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" target="_blank" href="#">Privacy & terms</a>
            </li>
          </ul>
          <!-- Helper link END -->
          <!-- Copyright -->
          <p class="small text-center mt-1">©2024 <a class="text-body" target="_blank" href="/">THEZOOM</a></p>

        </div>
      </div>
      <!-- Right sidebar END -->
      
    </div> 
    <!-- Row END -->
  </div>  
  <!-- Container END -->

</main>

  <!-- Post a story START -->
    <div class="modal fade" id="postStory" tabindex="-1" aria-labelledby="modalLabelCreateAlbum" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <!-- Modal feed header START -->
          <div class="modal-header">
            <h5 class="modal-title" id="modalLabelCreateAlbum">Create story</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <!-- Modal feed header END -->
          <!-- Modal feed body START -->
          <div class="modal-body">
            <!-- Form START -->
            <form method="POST" action="{{ route('crate.story')}}" enctype="multipart/form-data" class="row g-4">
              @csrf
              <!-- Photo START -->
              <div class="col-sm-12 col-lg-12">

                <input name="story_picture" type="file" class="form-control">
              
                @error('story_picture')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
              </div>
              <!-- Photo END -->

              <!-- Description -->
              <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="story Description..."></textarea>
              </div>

              <div class="modal-footer">
                <button type="submit" class="btn btn-danger-soft me-2" data-bs-dismiss="modal"> Cancel</button>
                <button type="submit" class="btn btn-success-soft">Create</button>
              </div>

            </form>
            <!-- Form END -->
          </div>
          <!-- Modal feed body END -->
          <!-- Modal footer -->
          <!-- Button -->

        </div>
      </div>
    </div>
  <!-- Post a story END -->

  <!-- Show follower/following START -->
    <x-show-follower-following :following="$following_user" :follower="$follower_user" />
  <!-- Show follower/following END -->

  <!-- Chat START -->
    <div aria-live="polite" aria-atomic="true" class="position-relative">
      <div class="toast-container toast-chat d-flex gap-3 align-items-end">

        <!-- Chat toast START -->
        <div id="chatToast" class="toast mb-0 bg-mode" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
          <div class="toast-header bg-mode">
            <!-- Top avatar and status START -->
            <div class="d-flex justify-content-between align-items-center w-100">
              <div class="d-flex">
                <div class="flex-shrink-0 avatar me-2">
                  <img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="">
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-0 mt-1">Frances Guerrero</h6>
                  <div class="small text-secondary"><i class="fa-solid fa-circle text-success me-1"></i>Online</div>
                </div>
              </div>
              <div class="d-flex">
              <!-- Call button -->
              <div class="dropdown">
                <a class="btn btn-secondary-soft-hover py-1 px-2" href="#" id="chatcoversationDropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></a>               
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="chatcoversationDropdown">
                  <li><a class="dropdown-item" href="#"><i class="bi bi-camera-video me-2 fw-icon"></i>Video call</a></li>
                  <li><a class="dropdown-item" href="#"><i class="bi bi-telephone me-2 fw-icon"></i>Audio call</a></li>
                  <li><a class="dropdown-item" href="#"><i class="bi bi-trash me-2 fw-icon"></i>Delete </a></li>
                  <li><a class="dropdown-item" href="#"><i class="bi bi-chat-square-text me-2 fw-icon"></i>Mark as unread</a></li>
                  <li><a class="dropdown-item" href="#"><i class="bi bi-volume-up me-2 fw-icon"></i>Muted</a></li>
                  <li><a class="dropdown-item" href="#"><i class="bi bi-archive me-2 fw-icon"></i>Archive</a></li>
                  <li class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#"><i class="bi bi-flag me-2 fw-icon"></i>Report</a></li>
                </ul>
              </div>
              <!-- Card action END -->
              <a class="btn btn-secondary-soft-hover py-1 px-2" data-bs-toggle="collapse" href="#collapseChat" aria-expanded="false" aria-controls="collapseChat"><i class="bi bi-dash-lg"></i></a>        
              <button class="btn btn-secondary-soft-hover py-1 px-2" data-bs-dismiss="toast" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
          </div>
          <!-- Top avatar and status END -->
            
          </div>
          <div class="toast-body collapse show" id="collapseChat">
            <!-- Chat conversation START -->
            <div class="chat-conversation-content custom-scrollbar h-200px">
              <!-- Chat time -->
              <div class="text-center small my-2">Jul 16, 2022, 06:15 am</div>
              <!-- Chat message left -->
              <div class="d-flex mb-1">
                <div class="flex-shrink-0 avatar avatar-xs me-2">
                  <img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="">
                </div>
                <div class="flex-grow-1">
                  <div class="w-100">
                    <div class="d-flex flex-column align-items-start">
                      <div class="bg-light text-secondary p-2 px-3 rounded-2">Applauded no discovery😊</div>
                      <div class="small my-2">6:15 AM</div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Chat message right -->
              <div class="d-flex justify-content-end text-end mb-1">
                <div class="w-100">
                  <div class="d-flex flex-column align-items-end">
                    <div class="bg-primary text-white p-2 px-3 rounded-2">With pleasure</div>
                  </div>
                </div>
              </div>
              <!-- Chat message left -->
              <div class="d-flex mb-1">
                <div class="flex-shrink-0 avatar avatar-xs me-2">
                  <img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="">
                </div>
                <div class="flex-grow-1">
                  <div class="w-100">
                    <div class="d-flex flex-column align-items-start">
                      <div class="bg-light text-secondary p-2 px-3 rounded-2">Please find the attached</div>
                      <!-- Files START -->
                      <!-- Files END -->
                      <div class="small my-2">12:16 PM</div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Chat message left -->
              <div class="d-flex mb-1">
                <div class="flex-shrink-0 avatar avatar-xs me-2">
                  <img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="">
                </div>
                <div class="flex-grow-1">
                  <div class="w-100">
                    <div class="d-flex flex-column align-items-start">
                      <div class="bg-light text-secondary p-2 px-3 rounded-2">How promotion excellent curiosity😮</div>
                      <div class="small my-2">3:22 PM</div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Chat message right -->
              <div class="d-flex justify-content-end text-end mb-1">
                <div class="w-100">
                  <div class="d-flex flex-column align-items-end">
                    <div class="bg-primary text-white p-2 px-3 rounded-2">And sir dare view.</div>
                    <!-- Images -->
                    <div class="d-flex my-2">
                      <div class="small text-secondary">5:35 PM</div>
                      <div class="small ms-2"><i class="fa-solid fa-check"></i></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Chat time -->
              <div class="text-center small my-2">2 New Messages</div>
              <!-- Chat Typing -->
              <div class="d-flex mb-1">
                <div class="flex-shrink-0 avatar avatar-xs me-2">
                  <img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="">
                </div>
                <div class="flex-grow-1">
                  <div class="w-100">
                    <div class="d-flex flex-column align-items-start">
                      <div class="bg-light text-secondary p-3 rounded-2">
                        <div class="typing d-flex align-items-center">
                          <div class="dot"></div>
                          <div class="dot"></div>
                          <div class="dot"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Chat conversation END -->
            <!-- Chat bottom START -->
            <div class="mt-2">
              <!-- Chat textarea -->
              <textarea class="form-control mb-sm-0 mb-3" placeholder="Type a message" rows="1"></textarea>
              <!-- Button -->
              <div class="d-sm-flex align-items-end mt-2">
                <button class="btn btn-sm btn-danger-soft me-2"><i class="fa-solid fa-face-smile fs-6"></i></button>
                <button class="btn btn-sm btn-secondary-soft me-2"><i class="fa-solid fa-paperclip fs-6"></i></button>
                <button class="btn btn-sm btn-success-soft me-2"> Gif </button>
                <button class="btn btn-sm btn-primary ms-auto"> Send </button>
              </div>
            </div>
            <!-- Chat bottom START -->
          </div>
        </div>
        <!-- Chat toast END -->

        <!-- Chat toast 2 START -->
        <div id="chatToast2" class="toast mb-0 bg-mode" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
          <div class="toast-header bg-mode">
            <!-- Top avatar and status START -->
            <div class="d-flex justify-content-between align-items-center w-100">
              <div class="d-flex">
                <div class="flex-shrink-0 avatar me-2">
                  <img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="">
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-0 mt-1">Lori Ferguson</h6>
                  <div class="small text-secondary"><i class="fa-solid fa-circle text-success me-1"></i>Online</div>
                </div>
              </div>
              <div class="d-flex">
              <!-- Call button -->
              <div class="dropdown">
                <a class="btn btn-secondary-soft-hover py-1 px-2" href="#" id="chatcoversationDropdown2" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></a>               
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="chatcoversationDropdown2">
                  <li><a class="dropdown-item" href="#"><i class="bi bi-camera-video me-2 fw-icon"></i>Video call</a></li>
                  <li><a class="dropdown-item" href="#"><i class="bi bi-telephone me-2 fw-icon"></i>Audio call</a></li>
                  <li><a class="dropdown-item" href="#"><i class="bi bi-trash me-2 fw-icon"></i>Delete </a></li>
                  <li><a class="dropdown-item" href="#"><i class="bi bi-chat-square-text me-2 fw-icon"></i>Mark as unread</a></li>
                  <li><a class="dropdown-item" href="#"><i class="bi bi-volume-up me-2 fw-icon"></i>Muted</a></li>
                  <li><a class="dropdown-item" href="#"><i class="bi bi-archive me-2 fw-icon"></i>Archive</a></li>
                  <li class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#"><i class="bi bi-flag me-2 fw-icon"></i>Report</a></li>
                </ul>
              </div>
              <!-- Card action END -->
              <a class="btn btn-secondary-soft-hover py-1 px-2" data-bs-toggle="collapse" href="#collapseChat2" role="button" aria-expanded="false" aria-controls="collapseChat2"><i class="bi bi-dash-lg"></i></a>        
              <button class="btn btn-secondary-soft-hover py-1 px-2" data-bs-dismiss="toast" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
          </div>
          <!-- Top avatar and status END -->
            
          </div>
          <div class="toast-body collapse show" id="collapseChat2">
            <!-- Chat conversation START -->
            <div class="chat-conversation-content custom-scrollbar h-200px">
              <!-- Chat time -->
              <div class="text-center small my-2">Jul 16, 2022, 06:15 am</div>
              <!-- Chat message left -->
              <div class="d-flex mb-1">
                <div class="flex-shrink-0 avatar avatar-xs me-2">
                  <img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="">
                </div>
                <div class="flex-grow-1">
                  <div class="w-100">
                    <div class="d-flex flex-column align-items-start">
                      <div class="bg-light text-secondary p-2 px-3 rounded-2">Applauded no discovery😊</div>
                      <div class="small my-2">6:15 AM</div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Chat message right -->
              <div class="d-flex justify-content-end text-end mb-1">
                <div class="w-100">
                  <div class="d-flex flex-column align-items-end">
                    <div class="bg-primary text-white p-2 px-3 rounded-2">With pleasure</div>
                  </div>
                </div>
              </div>
              <!-- Chat message left -->
              <div class="d-flex mb-1">
                <div class="flex-shrink-0 avatar avatar-xs me-2">
                  <img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="">
                </div>
                <div class="flex-grow-1">
                  <div class="w-100">
                    <div class="d-flex flex-column align-items-start">
                      <div class="bg-light text-secondary p-2 px-3 rounded-2">Please find the attached</div>
                      <!-- Files START -->
                      <!-- Files END -->
                      <div class="small my-2">12:16 PM</div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Chat message left -->
              <div class="d-flex mb-1">
                <div class="flex-shrink-0 avatar avatar-xs me-2">
                  <img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="">
                </div>
                <div class="flex-grow-1">
                  <div class="w-100">
                    <div class="d-flex flex-column align-items-start">
                      <div class="bg-light text-secondary p-2 px-3 rounded-2">How promotion excellent curiosity😮</div>
                      <div class="small my-2">3:22 PM</div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Chat message right -->
              <div class="d-flex justify-content-end text-end mb-1">
                <div class="w-100">
                  <div class="d-flex flex-column align-items-end">
                    <div class="bg-primary text-white p-2 px-3 rounded-2">And sir dare view.</div>
                    <!-- Images -->
                    <div class="d-flex my-2">
                      <div class="small text-secondary">5:35 PM</div>
                      <div class="small ms-2"><i class="fa-solid fa-check"></i></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Chat time -->
              <div class="text-center small my-2">2 New Messages</div>
              <!-- Chat Typing -->
              <div class="d-flex mb-1">
                <div class="flex-shrink-0 avatar avatar-xs me-2">
                  <img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="">
                </div>
                <div class="flex-grow-1">
                  <div class="w-100">
                    <div class="d-flex flex-column align-items-start">
                      <div class="bg-light text-secondary p-3 rounded-2">
                        <div class="typing d-flex align-items-center">
                          <div class="dot"></div>
                          <div class="dot"></div>
                          <div class="dot"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Chat conversation END -->
            <!-- Chat bottom START -->
            <div class="mt-2">
              <!-- Chat textarea -->
              <textarea class="form-control mb-sm-0 mb-3" placeholder="Type a message" rows="1"></textarea>
              <!-- Button -->
              <div class="d-sm-flex align-items-end mt-2">
                <button class="btn btn-sm btn-danger-soft me-2"><i class="fa-solid fa-face-smile fs-6"></i></button>
                <button class="btn btn-sm btn-secondary-soft me-2"><i class="fa-solid fa-paperclip fs-6"></i></button>
                <button class="btn btn-sm btn-success-soft me-2"> Gif </button>
                <button class="btn btn-sm btn-primary ms-auto"> Send </button>
              </div>
            </div>
            <!-- Chat bottom START -->
          </div>
        </div>
        <!-- Chat toast 2 END -->

      </div>
    </div>
  <!-- Chat END -->
    
@endauth

@endsection    