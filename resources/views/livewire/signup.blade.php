<div>

    {{-- ERROR --}}
    <div style=" font-size: 0.8em;">
        @if($errors->any())
            {!! implode('', $errors->all('<div class="alert alert-danger alert-dismissible fade show" role="alert">:message</div>')) !!}
        @endif

        @if(Session::get('error') && Session::get('error') != null)

            <div class="alert alert-secondary alert-dismissible fade show" role="alert">
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


    @if ($state == 0)
        <form wire:submit="checkemail()" method="POST" class="mt-4">
            @csrf
            
            <!-- Title -->
            <h2 style="text-align: center" class="h1 mb-2">Sign Up</h2>
            <p style="text-align: center">Have an account?<a href="/signin"> sign in</a></p>
            <br>
            
            <div class="mb-3 input-group-lg">
                <label for="email" class="form-label">Email address : </label>
                <input type="email" class="form-control" wire:model="email">

                @error('email')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <br>

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

                <div wire:loading.remove>
                    <button type="submit" class="btn btn-primary w-100"> 
                        next
                        <br>            
                    </button>
                </div>
                <div wire:loading.flex>
                    <button type="submit" style="padding: 8px 0px 0px 0px" class="btn btn-primary w-100"> 
                        next
                        <br>  
                        <div class="loader-container">
                            <div class="loader-line"></div>
                        </div>          
                    </button>
                </div>


        </form>
    @elseif($state == 1)
        <form wire:submit="signup()" method="POST" class="mt-4">
            @csrf
            
            <!-- Title -->
            <h2 style="text-align: center" class="h1 mb-2">Sign Up</h2>
            <p style="text-align: center">Have an account?<a href="/signin"> sign in</a></p>
            <br>

            <p style="text-align: center">Email address : {{$email}}</p><br>

            @if (isset($email))
                <div class="mb-3 input-group-lg">
                    <label for="user_name" class="form-label">user name : </label>
                    <input type="text" class="form-control" wire:model="user_name">

                    @error('user_name')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>
                
                <div class="mb-3 input-group-lg">
                    <label for="first_name" class="form-label">first name : </label>
                    <input type="text" class="form-control" wire:model="first_name">

                    @error('first_name')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>
                
                <div class="mb-3 input-group-lg">
                    <label for="last_name" class="form-label">last name : </label>
                    <input type="text" class="form-control" wire:model="last_name">

                    @error('last_name')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-3 input-group-lg">
                    
                    <label for="password" class="form-label">Password : </label>
                    <input type="password" class="form-control" wire:model="password">
                </div>

                <hr>
                <div class="mb-3 position-relative input-group-lg">
                <label for="verify_code" class="form-label">Verify code:</label>
                <input wire:model="verify_code" type="text" class="form-control" placeholder="Verify code">
                </div>
                <br>
                
                <button type="submit" class="btn btn-primary w-100">sign up</button>
            @endif
            
        </form>

        <form wire:submit="backToZero()" method="POST" class="mt-4">
            @csrf
            
            <button style="border: 1px solid rgb(122, 122, 122)" type="submit" class="btn w-100">back to add email</button>

        </form>


    @endif

</div>

{{-- <form action="{{route('signup.post')}}" method="POST" class="mt-4">
    @csrf
      
      <!-- Title -->
      <h2 style="text-align: center" class="h1 mb-2">Sign Up</h2>
      <p style="text-align: center">Have an account?<a href="/signin"> sign in</a></p>
      <br>
      <div class="mb-3 input-group-lg">
        <label for="user_name" class="form-label">user name : </label>
        <input value="{{old('user_name')}}" type="text" class="form-control" wire:model="user_name">

        @error('user_name')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>
      
      <div class="mb-3 input-group-lg">
        <label for="first_name" class="form-label">first name : </label>
        <input value="{{old('first_name')}}" type="text" class="form-control" wire:model="first_name">

        @error('first_name')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>
      
      <div class="mb-3 input-group-lg">
        <label for="last_name" class="form-label">last name : </label>
        <input value="{{old('last_name')}}" type="text" class="form-control" wire:model="last_name">

        @error('last_name')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>
      
      <div class="mb-3 input-group-lg">
        <label for="email" class="form-label">Email address : </label>
        <input value="{{old('email')}}" type="email" class="form-control" wire:model="email">

        @error('email')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      <div class="mb-3 input-group-lg">
        
        <label for="password" class="form-label">Password : </label>
        <input value="{{old('password')}}" type="password" class="form-control" wire:model="password">
      </div>
      
      <button type="submit" class="btn btn-primary">sign up</button>
</form> --}}
