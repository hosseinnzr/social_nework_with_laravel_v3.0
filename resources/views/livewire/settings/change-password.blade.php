<div>
    <div class="card">

        <!-- Title START -->
        <div class="card-header border-0 pb-0">
            <h5 class="card-title">Change password</h5>
        </div>
        <br>
        <div style="margin: 0px 20px 0px 20px; font-size: 0.8em;">
            @if($errors->any())
                {!! implode('', $errors->all('<div class="alert alert-danger alert-dismissible fade show" role="alert">:message</div>')) !!}
            @endif

            @if(Session::get('error') && Session::get('error') != null)

                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ Session::get('error') }}
                </div>
                @php
                Session::put('error', null)
                @endphp
            @endif

            @if(Session::get('success') && Session::get('success') != null)

                
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                </div>

                @php
                Session::put('success', null)
                @endphp
            @endif
        </div>

        <!-- Title START -->
        <div class="card-body">

          <!-- Settings START -->
          <form class="row g-3"  wire:submit="changePassword()" >
            @csrf

            <!-- Current password -->
            <div class="col-12">
              <label class="form-label">Current password</label>
              <input wire:model="current_password" value="{{ old('first_name')}}" type="text" class="form-control" type="password" placeholder="Enter Current password">
            </div>

            <!-- New password -->
            <div class="col-12">
              <label class="form-label">New password</label>
              <input wire:model="new_password" value="{{ old('first_name')}}" type="text" class="form-control" type="password" placeholder="Enter new password">
            </div>

            <!-- Confirm password -->
            <div class="col-12">
              <label class="form-label">Confirm new password</label>
              <input wire:model="new_password_confirmation" value="{{ old('first_name')}}" type="text" class="form-control" type="password" placeholder="Enter new password agian">
            </div>

            <!-- Button  -->
            <div class="col-12 text-end">
              <button type="submit" class="btn btn-primary mb-0">Update password</button>
            </div>
          </form>
          <!-- Settings END -->

        </div>
    </div>
</div>
