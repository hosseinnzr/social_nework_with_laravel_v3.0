@isset($post['post_picture'])
<img class="img-fluid" src='/post-picture/{{$post['post_picture']}}' alt="">
@endisset 

@isset($post['post_video'])
<img class="img-fluid" src='/video-cover/{{$post['video_cover']}}' alt=""
style="aspect-ratio: 1 / 1; width: 100%; object-fit: cover;">
@endisset 