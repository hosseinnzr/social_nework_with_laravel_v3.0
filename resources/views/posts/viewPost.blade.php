@extends('layout')

@section('title', 'show post')  

@section('content')
@auth
{{ csrf_field() }}

<main>
      
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

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
                      <li class="dropdown-item">
                          @livewire('profile.follow', ['user_id' => $post['UID']])                        
                      </li>
                      <li><a class="dropdown-item" href="#"> <i class="bi bi-slash-circle fa-fw pe-2"></i>Block {{$post['user_name']}}</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="#"> <i class="bi bi-flag fa-fw pe-2"></i>Report post</a></li>
                    </ul>
                </div>
                <!-- Card share action START -->
                </div>
            </div>
            <!-- Card header END -->

            <!-- show post START -->
            <div class="card-header">
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

</main>

@endauth

@endsection  