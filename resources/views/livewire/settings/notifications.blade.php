<div>
    <ul class="list-group list-group-flush">
        <!-- Notification list item -->
        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
          <div class="me-2">
            <h6 class="mb-0">Likes Email Notification</h6>
            <p class="small mb-0">receiving like notifications via email</p>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="comSwitchCheckChecked" 
                        wire:click="toggleLikeNotification" {{ $like_notification ? 'checked' : '' }}>
          </div>
        </li>
        <!-- Notification list item -->
        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
          <div class="me-2">
            <h6 class="mb-0">Comments Email Notification</h6>
            <p class="small mb-0">receiving Comments notifications via email</p>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="comSwitchCheckChecked" 
                        wire:click="toggleCommentNotification" {{ $comment_notification ? 'checked' : '' }}>
          </div>
        </li>
        <!-- Notification list item -->
        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
          <div class="me-2">
            <h6 class="mb-0">Follow Email Notification</h6>
            <p class="small mb-0">receiving Follow notifications via email</p>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="comSwitchCheckChecked" 
                        wire:click="toggleFollowNotification" {{ $follow_notification ? 'checked' : '' }}>
          </div>
        </li>
        <!-- Notification list item -->
        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
            <div class="me-2">
              <h6 class="mb-0">Follow Request Email Notification</h6>
              <p class="small mb-0">receiving Follow Request notifications via email</p>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="comSwitchCheckChecked" 
                wire:click="toggleFollowRequestNotification" {{ $follow_request_notification ? 'checked' : '' }}>
            </div>
        </li>
      </ul>
</div>
