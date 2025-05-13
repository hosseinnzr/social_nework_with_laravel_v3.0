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
          @if ($posts != '[]')
            <div class="card card-body mb-4">
              <ul class="nav nav-pills nav-stack small fw-normal">
                <li class="nav-item">
                  <a class="nav-link bg-light py-1 px-2 mb-0"> <i class="bi bi-hash text-success"></i>{{$hash_tag}}</a>
                </li>
              </ul>
            </div>
          @else
            <div class="card card-body mb-4">
              <ul class="nav nav-pills nav-stack small fw-normal">There are no posts with
                <li class="nav-item">
                  <a class="nav-link bg-light py-1 px-2 mb-0"> <i class="bi bi-hash text-success"></i>{{$hash_tag}}</a>
                </li>hashtag.
              </ul>
            </div>
          @endif          
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
                  <x-post-cover-in-list :post="$post"/>               
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
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardShareAction8">
                              <li><a class="dropdown-item" href="#"> <i class="bi bi-person-x fa-fw pe-2"></i>Unfollow {{$post['user_name']}}</a></li>
                              <li><a class="dropdown-item" href="#"> <i class="bi bi-slash-circle fa-fw pe-2"></i>Block {{$post['user_name']}}</a></li>
                              <li><a class="dropdown-item" href="/p/{{$post['id']}}"> <i class="bi bi-file-post-fill"></i> view post</a></li>
                              
                              <li>
                                <div data-bs-toggle="modal" data-bs-target="#reportModal{{$post['id']}}" aria-controls="offcanvasChat">
                                  <a class="dropdown-item" href="#"> <i class="bi bi-flag fa-fw pe-2"></i>Report post</a>
                                </div>
                              </li>

                            </ul>
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
                              <!-- Show post content START -->
                              <x-show-post-content :post="$post"/>
                              <!-- Show post content END -->

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
                                  @if ($tag != '')
                                    <a href="/explore/?tag={{str_replace('#', '', $tag)}}">#{{$tag}} </a>
                                  @endif
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

                <!-- scroll report post modal START -->
                <div class="modal fade" id="reportModal{{$post['id']}}" tabindex="-1" aria-hidden="true" wire:ignore>
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                      <!-- Modal feed header START -->
                      <div class="modal-header">
                        <h6 class="modal-title">Report Post</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <!-- Modal feed header END -->

                      <!-- main START -->
                        @livewire('report.report-post', ['relatedContentId' => $post['id']])
                      <!-- main END -->
                      
                    </div>
                  </div>
                </div>
                <!-- scroll report post modal END -->   

              </div>
              <!-- Photo item END -->
            @endforeach

          </div> 
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