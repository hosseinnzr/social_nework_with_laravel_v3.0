<div>
    <div class="card-body">
        <!-- Privacy START -->
        <ul class="list-group">
    
            <!-- Privacy item -->
            <li class="list-group-item d-md-flex justify-content-between align-items-start">
                <div class="me-2">
                    <p class="mb-0">Private account</p>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="comSwitchCheckChecked" 
                        wire:click="togglePrivateAccount" {{ $isPrivate ? 'checked' : '' }}>
                </div>
            </li>
    
        </ul>
        <!-- Privacy END -->
    </div>
    
</div>
