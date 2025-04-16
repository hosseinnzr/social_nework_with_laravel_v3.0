@auth
  
<header class="navbar-light fixed-top header-static bg-mode">
	<!-- Logo Nav START -->
	<nav class="navbar navbar-expand-lg">
		<div class="container">
			<!-- Logo START -->
			<a class="navbar-brand" href="/">
        <img class="light-mode-item navbar-brand-item" src="{{ asset("assets/images/favicon.png") }}" alt="logo">
				<img class="dark-mode-item navbar-brand-item"  src="{{ asset("assets/images/favicon.png") }}" alt="logo">
			</a>
			<!-- Logo END -->

			<!-- Responsive navbar toggler -->
			<button class="navbar-toggler ms-auto icon-md btn btn-light p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <i class="bi bi-search"></i>
      </button>

      <!-- Nav Search START -->
      <div class="collapse navbar-collapse" id="navbarCollapse">
          <div class="nav mt-3 mt-lg-0 flex flex-nowrap align-items-center px-4 px-lg-0">
            <div class="nav-item w-100">

              <!-- Nav Search START -->
              @livewire('search-bar')
              <!-- Nav Search END -->

          </div>
        </div>
				<a class="nav-link" id="pagesMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
      </div>
      <!-- Nav Search END -->
      


			<!-- Nav right START -->
			<ul class="nav flex-nowrap align-items-center ms-sm-3 list-unstyled">

        <!-- chat -->
				<li class="nav-item ms-2" title="chat">
					<a class="nav-link icon-md btn btn-light p-0" href="{{ route('chat') }}">
						<i class="bi bi-chat-left-text-fill fs-6"> </i>
					</a>
				</li>
        
        <!-- add post -->
        <li class="nav-item ms-2" title="add post">
					<a class="nav-link icon-md btn btn-light p-0" href="{{ route('post.store')}}">
						<i class="fa-solid fa-plus fs-6"></i>
					</a>
				</li>

        <!-- explore -->
        <li class="nav-item ms-2" title="explore">
					<a class="nav-link icon-md btn btn-light p-0" href="{{ route('explore')}}">
						<i class="bi bi-compass-fill fs-6"> </i>
					</a>
				</li>

        <!-- notifications -->
        <li class="nav-item dropdown ms-2" title="notifications">
          <a class="nav-link icon-md btn btn-light p-0" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
              <i class="bi bi-bell-fill fs-6"> </i>
          </a>
          <div class="dropdown-menu dropdown-animation dropdown-menu-end dropdown-menu-size-md p-0 shadow-lg border-0" aria-labelledby="notifDropdown">

          @livewire('notifications.notifications-header')
          </div>
        </li>
        
        <!-- user info -->
        <li class="nav-item ms-2 dropdown">
					<a class="nav-link btn icon-md p-0" href="#" id="profileDropdown" role="button" data-bs-auto-close="outside" data-bs-display="static" data-bs-toggle="dropdown" aria-expanded="false">
						<img class="avatar-img rounded-2" src="{{auth()->user()->profile_pic}}" alt="">
					</a>
          <ul class="dropdown-menu dropdown-animation dropdown-menu-end pt-3 small me-md-n3" aria-labelledby="profileDropdown">
            <!-- Profile info -->
            <li class="px-3">
              <div class="d-flex align-items-center position-relative">
                <!-- Avatar -->
                <div class="avatar me-3">
                  <img class="avatar-img rounded-circle" src="{{auth()->user()->profile_pic}}" alt="avatar">
                </div>
                <div>
                  <a class="h6 stretched-link" href="/user/{{auth()->user()->user_name}}">{{auth()->user()->first_name}} {{auth()->user()->last_name}}</a>
                  <p class="small m-0">{{auth()->user()->user_name}}</p>
                </div>
              </div>
            </li>

            <li> <hr class="dropdown-divider"></li>

            <!-- Links -->
            <li><a class="dropdown-item" href="{{ route('settings')}}"><i class="bi bi-gear fa-fw me-2"></i>Settings</a></li>
            <li> 
              <a class="dropdown-item" href="https://support.webestica.com/" target="_blank">
                <i class="fa-fw bi bi-life-preserver me-2"></i>Support
              </a> 
            </li>
            <li class="dropdown-divider"></li>

            <li>
              <form action="{{route('logout')}}" method="POST">
                @csrf
                <button style="color: red;" type="submit" class="dropdown-item"><i class="bi bi-power fa-fw me-2"></i>Sign Out</button>
              </form>
            </li>
            
            <li> <hr class="dropdown-divider"></li>
            <!-- Dark mode switch START -->
            <li>
              <div class="modeswitch-wrap" id="darkModeSwitch">
                <div class="modeswitch-item">
                  <div class="modeswitch-icon"></div>
                </div>
                <span>Dark mode</span>
              </div>
            </li> 
            <!-- Dark mode switch END -->
          </ul>
				</li>
        
			</ul>
			<!-- Nav right END -->
		</div>
	</nav>
	<!-- Logo Nav END -->
</header>

@endauth
