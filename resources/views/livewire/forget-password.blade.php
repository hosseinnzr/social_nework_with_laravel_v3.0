<div>

    <div style=" font-size: 0.8em;">
        @if($errors->any())
            {!! implode('', $errors->all('<div class="alert alert-danger alert-dismissible fade show" role="alert">:message</div>')) !!}
        @endif

        @if(Session::get('error') && Session::get('error') != null)

            <div class="alert alert-secondary  alert-dismissible fade show" role="alert">
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

    @if ($send_code == false)
        <form wire:submit="sendCode()" method="POST" class="mt-4">
            @csrf

            <div class="mb-3 position-relative input-group-lg">
            <label for="email" class="form-label">Email:</label>
            <input wire:model="email" type="text" class="form-control" placeholder="Email">
            </div>

            <br>
            <!-- Button -->
            <style>
                .loader-container {
                    margin-top: 4px;
                    width: 100%;
                    height: 4px;
                    background-color: #e0e0e0;
                    position: relative;
                    overflow: hidden;
                    border-radius: 0px 0px 5px 5px;
                }

                .loader-line {
                    width: 10%;
                    height: 100%;
                    background-color: #0f6fec;
                    position: absolute;
                    top: 0;
                    left: 0;
                    animation: moveLine 1s linear infinite;
                }

                @keyframes moveLine {
                    0% {
                        left: 0;
                    }
                    100% {
                        left: 100%;
                    }
                }
            </style>  

            <div class="d-grid">
                <div wire:loading.remove>
                    <button type="submit" class="btn btn-primary w-100"> 
                        send verify code
                        <br>            
                    </button>
                </div>
                <div wire:loading.flex>
                    <button type="submit" style="padding: 8px 0px 0px 0px" class="btn btn-primary w-100"> 
                        send verify code
                        <br>  
                        <div class="loader-container">
                            <div class="loader-line"></div>
                        </div>          
                    </button>
                </div>
            </div>
        </form>
    @else
        <form wire:submit="forgotPassword()" method="POST" class="mt-4">
            @csrf
            <p>email send to {{$email}}</p>

            <div class="mb-3 position-relative input-group-lg">
            <label for="new_password" class="form-label">New password:</label>
            <input wire:model="new_password" type="text" class="form-control" placeholder="New password" value="{{ old('new_password')}}">
            </div>

            <div class="mb-3 position-relative input-group-lg">
            <label for="confirm_new_password" class="form-label">Confirm password:</label>
            <input wire:model="confirm_new_password" type="text" class="form-control" placeholder="Confirm password" value="{{ old('confirm_new_password')}}">
            </div>
            <hr>
            <div class="mb-3 position-relative input-group-lg">
            <label for="verify_code" class="form-label">Verify code:</label>
            <input wire:model="verify_code" type="text" class="form-control" placeholder="Verify code">
            </div>
            <br>
            <!-- Button -->
            <div class="d-grid">
            <button type="submit" class="btn btn-lg btn-primary-soft">reset password</button>
            </div>
        </form>
    @endif
</div>
