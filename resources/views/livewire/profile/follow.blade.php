<div>
    @if ( $state == 1 )

      <a style="font-size: 26px" class="btn btn-secondary-soft me-2 py-0" href="#!" data-bs-toggle="modal" data-bs-target="#feedActionPhoto"><i class="bi bi-qr-code-scan"></i></a>
                
      <!-- Button -->
      <div class="modal fade" id="feedActionPhoto" tabindex="-1" aria-labelledby="feedActionPhotoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <!-- Modal feed header START -->
            <div class="modal-header">
              <h5 class="modal-title" id="feedActionPhotoLabel">QR</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
              <div class="modal-body d-flex justify-content-center">
                <p>{{$qr_code}}</p>
              </div>
          </div>
        </div>
      </div>
      <!-- Button -->

      <a class="btn btn-success-soft me-2" type="submit" href="{{ route('post') }}">
        <span><i class="fa fa-add"></i> Add post</span>
      </a>

    @elseif ( $state == 2 )    

      <button wire:click="unfollow({{$user_id}})" class="btn btn-primary-soft me-2"><i class="fa fa-user"></i> unfollow</button>
      
      <form action="/chat" method="get" class="ms-auto me-auto mt-3">
        @csrf
        <button type="submit" class="btn btn-success-soft me-2"><i class="fa bi-chat-left-text-fill"></i> message</button>
      </form>

    @elseif ( $state == 3 )

      <button wire:click="delete_follow_request({{$user_id}})" type="submit" class="btn btn-secondary-soft me-2">delete Requested</button>
    
    @elseif ( $state == 4 )

      <button wire:click="follow_request({{$user_id}})" type="submit" class="btn btn-secondary-soft me-2">Requeste</button>
    
    @else

      <button wire:click="follow({{$user_id}})" class="btn btn-primary-soft me-2">follow</button>

    @endif
</div>
