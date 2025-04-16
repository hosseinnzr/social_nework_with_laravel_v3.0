@extends('layout')
@if (isset($hash_tag))
  @section('title', "explore - #$hash_tag")
@else
  @section('title', 'explore')  
@endif

@section('content')
@auth
{{ csrf_field() }}


<main>      
  <!-- Container START -->
  <div style="margin: 0px"  class="container">
    <!-- Row START -->
    <div class="row g-4">

      <!-- Left sidebar START -->
      <div class="col-3">

      </div>
      <!-- Left sidebar END -->

      <!-- Main content START -->
      <div style="margin: 0px; padding: 0px" class="col-md-8 col-lg-6 vstack gap-2">

        <br>

        <!-- Show hashtag START -->
        @if (isset($hash_tag))
          <div class="card card-body mb-4">
            <ul class="nav nav-pills nav-stack small fw-normal">
              <li class="nav-item">
                <a class="nav-link bg-light py-1 px-2 mb-0" data-bs-toggle="modal" data-bs-target="#feedActionPhoto"> <i class="bi bi-hash text-success pe-1"></i>{{$hash_tag}}</a>
              </li>
            </ul>
          </div>
        @endif
        <!-- Show hashtag END -->

        @if ($posts != '[]')
        <div class="row g-3">
                    
            @foreach ($posts as $post)
              <!-- script for open send-post modal -->
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

              <!-- Photo item START -->
              <div style="padding: 2px; margin: 0px" class="col-4 col-lg-4 position-relative">

                <div data-bs-toggle="modal" data-bs-target="#showSavePost{{$post['id']}}" aria-controls="offcanvasChat">
                  <img class="img-fluid" src='/post-picture/{{$post['post_picture']}}' alt="">
                </div>

                    <!-- scroll show post START -->
                    <div class="modal fade" id="showSavePost{{$post['id']}}" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">

                          <!-- Modal feed header START -->
                          <div class="modal-header">

                            <div class="d-flex align-items-center justify-content-between">
                              <div class="d-flex align-items-center">
                                <!-- Avatar -->
                                <div class="avatar me-2">
                                  <img class="avatar-img rounded-circle" src={{$post['user_profile_pic']}}>
                                </div>
                                <!-- Info -->
                                <div>
                                  <div class="nav nav-divider">
                                    <h6 class="nav-item card-title mb-0"><a href="/user/{{$post['user_name']}}">{{$post['user_name']}}</a></h6>
                                    
                                    <small>&nbsp; &nbsp;{{$post['created_at']->diffForHumans()}}</small>

                                  </div>

                                </div>
                              </div>
                              <!-- Card feed action dropdown START -->
                              <div class="dropdown">
                                <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardShareAction8" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                                </a>
                                <!-- Card share action dropdown menu -->     
                                @if ($post['UID'] == Auth::id())
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardShareAction8">
                                  <li><a style="color: rgb(10, 0, 195)" class="dropdown-item" type="submit" href="{{ route('post', ['id' => $post['id']]) }}"> <i class="bi bi-pencil fa-fw pe-2"></i>Edit post</a></li>
                                  <li><a class="dropdown-item" href="/p/{{$post['id']}}"> <i class="bi bi-file-post-fill"></i> view post</a></li>
                                  <li><a class="dropdown-item" href="#"> <i class="bi bi-archive fa-fw pe-2"></i>Archive</a></li>
                                  {{-- <li><a style="color: red" class="dropdown-item" type="submit" href="{{ route('delete', ['id' => $post['id']]) }}"> <i class="bi bi-x-circle fa-fw pe-2"></i>Delete post</a></li> --}}
                                </ul>
                                @else
                                {{-- <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardShareAction8">
                                  <li><a class="dropdown-item" href="#"> <i class="bi bi-person-x fa-fw pe-2"></i>Unfollow {{$user['user_name']}}</a></li>
                                  <li><a class="dropdown-item" href="#"> <i class="bi bi-slash-circle fa-fw pe-2"></i>Block {{$user['user_name']}}</a></li>
                                  <li><a class="dropdown-item" href="/p/{{$post['id']}}"> <i class="bi bi-file-post-fill"></i> view post</a></li>
                                  <li><hr class="dropdown-divider"></li>
                                  <li><a class="dropdown-item" href="#"> <i class="bi bi-flag fa-fw pe-2"></i>Report post</a></li>
                                </ul> --}}
                                @endif                 
                              </div>
                              <!-- Card feed action dropdown END -->
                            </div>
                            
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <!-- Modal feed header END -->

                          <!-- show post START -->
                            <!-- Card body START -->
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

                                    @foreach(explode(",", $post['tag']) as $tag)
                                    <a href="/explore/?tag={{str_replace('#', '', $tag)}}">#{{$tag}} </a>
                                    @endforeach
                                    <br>
                                    <br>
                                    @livewire('add-comments', ['postId' => $post['id'], 'post' => $post])
                                  </div>

                                </div>

                              </div>
                            </div>
                            <!-- Card body END -->
                          <!-- show post END -->
                        </div>
                      </div>
                    </div>
                    <!-- scroll show post END -->

              </div>
              <!-- Photo item END -->
            @endforeach

          </div> 
        @else    
          <!-- Card feed item START -->
          <div class="card">
            <!-- Card header START -->
            <div class="card-header d-flex justify-content-between align-items-center border-0 pb-0">
              <h6 class="card-title mb-0">People you may know</h6>
              <button class="btn btn-sm btn-primary-soft"> See all </button>
            </div>      
            <!-- Card header START -->
  
            <!-- Card body START -->
            <div class="card-body">
              <div class="tiny-slider arrow-hover">
                <div class="tiny-slider-inner ms-n4" data-arrow="true" data-dots="false" data-items-xl="3" data-items-lg="2" data-items-md="2" data-items-sm="2" data-items-xs="1" data-gutter="12" data-edge="30">
                  <!-- Slider items -->
                  <div> 
                    <!-- Card add friend item START -->
                    <div class="card shadow-none text-center">
                      <!-- Card body -->
                      <div class="card-body p-2 pb-0">
                        <div class="avatar avatar-xl">
                          <a href="#!"><img class="avatar-img rounded-circle" src="assets/images/avatar/09.jpg" alt=""></a>
                        </div>
                        <h6 class="card-title mb-1 mt-3"> <a href="#!"> Amanda Reed </a></h6>
                        <p class="mb-0 small lh-sm">50 mutual connections</p>
                      </div>
                      <!-- Card footer -->
                      <div class="card-footer p-2 border-0">
                        <button class="btn btn-sm btn-primary-soft w-100"> Add friend </button>
                      </div>
                    </div>
                    <!-- Card add friend item END -->
                  </div>
                  <div>
                    <!-- Card add friend item START -->
                    <div class="card shadow-none text-center">
                      <!-- Card body -->
                      <div class="card-body p-2 pb-0">
                        <div class="avatar avatar-story avatar-xl">
                          <a href="#!"><img class="avatar-img rounded-circle" src="assets/images/avatar/10.jpg" alt=""></a>
                        </div>
                        <h6 class="card-title mb-1 mt-3"> <a href="#!"> Larry Lawson </a></h6>
                        <p class="mb-0 small lh-sm">33 mutual connections</p>
                      </div>
                      <!-- Card footer -->
                      <div class="card-footer p-2 border-0">
                        <button class="btn btn-sm btn-primary-soft w-100"> Add friend </button>
                      </div>
                    </div>
                    <!-- Card add friend item END -->
                  </div>
                  <div>
                    <!-- Card add friend item START -->
                    <div class="card shadow-none text-center">
                      <!-- Card body -->
                      <div class="card-body p-2 pb-0">
                        <div class="avatar avatar-xl">
                          <a href="#!"><img class="avatar-img rounded-circle" src="assets/images/avatar/11.jpg" alt=""></a>
                        </div>
                        <h6 class="card-title mb-1 mt-3"> <a href="#!"> Louis Crawford </a></h6>
                        <p class="mb-0 small lh-sm">45 mutual connections</p>
                      </div>
                      <!-- Card footer -->
                      <div class="card-footer p-2 border-0">
                        <button class="btn btn-sm btn-primary-soft w-100"> Add friend </button>
                      </div>
                    </div>
                    <!-- Card add friend item END -->
                  </div>
                  <div>
                    <!-- Card add friend item START -->
                    <div class="card shadow-none text-center">
                      <!-- Card body -->
                      <div class="card-body p-2 pb-0">
                        <div class="avatar avatar-xl">
                          <a href="#!"><img class="avatar-img rounded-circle" src="assets/images/avatar/12.jpg" alt=""></a>
                        </div>
                        <h6 class="card-title mb-1 mt-3"> <a href="#!"> Dennis Barrett </a></h6>
                        <p class="mb-0 small lh-sm">21 mutual connections</p>
                      </div>
                      <!-- Card footer -->
                      <div class="card-footer p-2 border-0">
                        <button class="btn btn-sm btn-primary-soft w-100"> Add friend </button>
                      </div>
                    </div>
                    <!-- Card add friend item END -->
                  </div>
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
      
    </div> 
    <!-- Row END -->
  </div>  
  <!-- Container END -->

</main>

@endauth

@endsection    