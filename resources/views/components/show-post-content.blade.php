@isset($post['post_picture'])
<img class="card-img" src="/post-picture/{{$post['post_picture']}}" alt="Post">
@endisset 

@isset($post['post_video'])
  <div class="card-image">
    <div class="overflow-hidden fullscreen-video w-100">
      <!-- HTML video START -->
      <div class="player-wrapper card-img-top overflow-hidden"
          style="display: flex; justify-content: center; align-items: center; height: 60vh; max-height: 60vh;">
        <video class="player-html" controls poster="video-cover/{{$post['video_cover']}}"
              style="object-fit: contain; max-width: 100%; max-height: 100%; height: auto; width: auto;" muted>
          <source src="/post-video/{{$post['post_video']}}" type="video/mp4">
        </video>
      </div>
      <!-- HTML video END -->
    </div>
  </div>
@endisset