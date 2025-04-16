@extends('layout')
@section('title', "settings")
@section('content')
@auth
  {{ csrf_field() }}

<!-- **************** MAIN CONTENT START **************** -->
<main>
  <!-- Container START -->
  <div class="container">
    <div class="row">

      <!-- Sidenav START -->
      <div class="col-lg-3">

        <!-- Advanced filter responsive toggler START -->
				<!-- Divider -->
				<div class="d-flex align-items-center mb-4 d-lg-none">
					<button class="border-0 bg-transparent" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
						<i class="btn btn-primary fw-bold fa-solid fa-sliders"></i>
            <span class="h6 mb-0 fw-bold d-lg-none ms-2">Settings</span>
					</button>
				</div>
				<!-- Advanced filter responsive toggler END -->

        <nav class="navbar navbar-light navbar-expand-lg mx-0">
          <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar">
            <!-- Offcanvas header -->
						<div class="offcanvas-header">
							<button type="button" class="btn-close text-reset ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
						</div>

            <!-- Offcanvas body -->
            <div class="offcanvas-body p-0">
              <!-- Card START -->
              <div class="card w-100">
                <!-- Card body START -->
                <div class="card-body">

                <!-- Side Nav START -->
                <ul class="nav nav-tabs nav-pills nav-pills-soft flex-column fw-bold gap-2 border-0">
                  <li class="nav-item" data-bs-dismiss="offcanvas">
                    <a class="nav-link d-flex mb-0 active" href="#nav-setting-tab-1" data-bs-toggle="tab"> <img class="me-2 h-20px fa-fw" src="{{asset("assets/images/icon/person-outline-filled.svg")}}" alt=""><span>Account </span></a>
                  </li>
                  <li class="nav-item" data-bs-dismiss="offcanvas">
                    <a class="nav-link d-flex mb-0" href="#nav-setting-tab-2" data-bs-toggle="tab"> <img class="me-2 h-20px fa-fw" src="{{asset("assets/images/icon/notification-outlined-filled.svg")}}" alt=""><span>Notification </span></a>
                  </li>
                  <li class="nav-item" data-bs-dismiss="offcanvas">
                    <a class="nav-link d-flex mb-0" href="#nav-setting-tab-3" data-bs-toggle="tab"> <img class="me-2 h-20px fa-fw" src="{{asset("assets/images/icon/shield-outline-filled.svg")}}" alt=""><span>Privacy and safety </span></a>
                  </li>
                  <li class="nav-item" data-bs-dismiss="offcanvas">
                    <a class="nav-link d-flex mb-0" href="#nav-setting-tab-4" data-bs-toggle="tab"> <img class="me-2 h-20px fa-fw" src="{{asset("assets/images/icon/handshake-outline-filled.svg")}}" alt=""><span>Communications </span></a>
                  </li>
                  <li class="nav-item" data-bs-dismiss="offcanvas">
                    <a class="nav-link d-flex mb-0" href="#nav-setting-tab-5" data-bs-toggle="tab"> <img class="me-2 h-20px fa-fw" src="{{asset("assets/images/icon/chat-alt-outline-filled.svg")}}" alt=""><span>Messaging </span></a>
                  </li>
                  <li class="nav-item" data-bs-dismiss="offcanvas">
                    <a class="nav-link d-flex mb-0" href="#nav-setting-tab-6" data-bs-toggle="tab"> <img class="me-2 h-20px fa-fw" src="{{asset("assets/images/icon/trash-var-outline-filled.svg")}}" alt=""><span>Delete account </span></a>
                  </li>
                </ul>
                <!-- Side Nav END -->

              </div>
              <!-- Card body END -->
              <!-- Card footer -->
              <div class="card-footer text-center py-2">
                <a class="btn btn-link text-secondary btn-sm" type="submit" href="{{ route('profile', ['user_name' => Auth::user()->user_name]) }}">View Profile </a>
              </div>
              </div>
            <!-- Card END -->
            </div>
            <!-- Offcanvas body -->

            <!-- Helper link START -->
          <ul class="nav small mt-4 justify-content-center lh-1">
            <li class="nav-item">
              <a class="nav-link" target="_blank" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" target="_blank" href="/settings">Settings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" target="_blank" href="#">Support </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" target="_blank" href="#">Docs </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" target="_blank" href="#">Help</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" target="_blank" href="#">Privacy & terms</a>
            </li>
          </ul>
          <!-- Helper link END -->
          <!-- Copyright -->
          <p class="small text-center mt-1">©2024 <a class="text-body" target="_blank" href="/">THEZOOM</a></p>
          
          </div>
        </nav>
      </div>
      <!-- Sidenav END -->

        <!-- Main content START -->
        <div class="col-lg-6 vstack gap-4">
          <!-- Settings Tab content START -->
          <div class="tab-content py-0 mb-0">

            <!-- Account settings tab START -->
            <div class="tab-pane show active fade" id="nav-setting-tab-1">
              <!-- General settings START -->
              <div class="card mb-4">
                
                <!-- Title General Settings -->
                <div class="card-header border-0 pb-0">
                  <h1 class="h5 card-title">General Settings</h1>
                </div>
                <!-- Body General Settings -->
                <div class="card-body">
                  <!-- Form settings START -->
                  <form  method="POST" action="{{ route('settings.post') }}" class="row g-3" enctype="multipart/form-data">
                    @csrf

                    <!-- Profile picture -->
                    <div class="col-sm-12 col-lg-12">
                      <label class="form-label">Profile picture</label>
                      <input name="profile_pic" type="file" class="form-control" value="1234">
                    
                      @error('profile_pic')
                      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                      @enderror
                    </div>
                    
                    <!-- First name -->
                    <div class="col-sm-6 col-lg-4">
                      <label class="form-label">First name</label>
                      <input name="first_name" value="{{ Auth::user()->first_name ?? old('first_name')}}" type="text" class="form-control" placeholder="">
                    
                      @error('first_name')
                      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                      @enderror
                    </div>
                    <!-- Last name -->
                    <div class="col-sm-6 col-lg-4">
                      <label class="form-label">Last name</label>
                      <input name="last_name" value="{{ Auth::user()->last_name ?? old('last_name')}}" type="text" class="form-control" placeholder="">
                    
                      @error('last_name')
                      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                      @enderror
                    </div>
                    <!-- Additional name -->
                    <div class="col-sm-6 col-lg-4">
                      <label class="form-label">Additional name</label>
                      <input name="additional_name" value="{{ Auth::user()->additional_name ?? old('additional_name')}}" type="text" class="form-control" placeholder="">
                    
                      @error('additional_name')
                      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                      @enderror
                    </div>
                    <!-- User name -->
                    <div class="col-sm-6">
                      <label class="form-label">User name</label>
                      <input name="user_name" value="{{ Auth::user()->user_name ?? old('user_name')}}" type="text" class="form-control" placeholder="">
                    
                      @error('user_name')
                      <p class="text-red-500 text-xs mt-1">{{$errors->first('user_name')}}</p>
                      @enderror
                      
                    </div>
                    <!-- Birthday -->
                    <div class="col-lg-6">
                      <label class="form-label">Birthday </label>
                      <input name="birthday" value="{{ Auth::user()->birthday ?? old('birthday')}}" type="date" class="form-control">
                    
                      @error('birthday')
                      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                      @enderror
                    </div>
                    <!-- Phone number -->
                    <div class="col-sm-6">
                      <label class="form-label">Phone number</label>
                      <input name="phone" type="text" class="form-control" placeholder="0912 345 6789" value="{{ Auth::user()->phone ?? old('phone')}}">
                    
                      @error('phone')
                      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                      @enderror
                    </div>
                    <!-- email number -->
                    {{-- <div class="col-sm-6">
                      <label class="form-label">Email</label>
                      <input name="email" type="text" class="form-control" placeholder="" value="{{ Auth::user()->email  ?? old('email ')}}">
                    
                      @error('email')
                      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                      @enderror
                    </div> --}}
                    <!-- Page information -->
                    <div class="col-12">
                      <label class="form-label">Biography</label>
                      <textarea name="biography" class="form-control" rows="4" placeholder="Description (Required)">{{ Auth::user()->biography ?? old('biography')}}</textarea>
                      <small>Character limit: 300</small>

                      @error('biography')
                      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                      @enderror
                    </div>
                    <!-- Button  -->
                    <div class="col-12 text-end">
                      <button type="submit">
                        <div class="btn btn-primary">Save changes</div>
                      </button>
                    </div>
                  </form>
                  <!-- Settings END -->
                </div>

              <!-- Card body END -->
              </div>
              <!-- General settings END -->

              <!-- Email Update START -->
              <div class="card mb-4">
                
                <!-- Title Email Update -->
                <div class="card-header border-0 pb-0">
                  <h1 class="h5 card-title">Email Update</h1>
                </div>

                <!-- Body Email Update -->
                <div class="card-body">

                  @livewire('update-email')

                </div>

              <!-- Card body END -->
              </div>

            </div>

            <!-- Notification tab START -->
            <div class="tab-pane fade" id="nav-setting-tab-2">
              <!-- Notification START -->
              <div class="card">
                <!-- Card header START -->
                <div class="card-header border-0 pb-0">
                  <h5 class="card-title">Notification</h5>
                  {{-- <p class="mb-0">Tried law yet style child. The bore of true of no be deal. Frequently sufficient to be unaffected. The furnished she concluded depending procuring concealed. </p> --}}
                </div>
                <!-- Card header START -->
                <!-- Card body START -->
                <div class="card-body pb-0">
                  <!-- Notification START -->
                  @livewire('settings.notifications')
                  <!-- Notification END -->
                </div>
              <!-- Card body END -->
            </div>
              <!-- Notification END -->
            </div>
            <!-- Notification tab END -->

            <!-- Privacy and safety tab START -->
            <div class="tab-pane fade" id="nav-setting-tab-3">
              <!-- Privacy and safety START -->
              <div class="card">
                <!-- Card header START -->
                <div class="card-header border-0 pb-0">
                  <h5 class="card-title">Account privacy</h5>
                  <p class="fs-12">When your account is public, your profile and posts can be seen by anyone, on or off Instagram, even if they don't have an Instagram account.</p>

                  <p class="mb-0">When your account is private, only the followers you approve can see what you share, including your photos or videos on hashtag and location pages, and your followers and following lists. Certain info on your profile, like your profile picture and username, is visible to everyone on and off Instagram. Learn more</p>

                </div>
                <!-- Card header START -->

                <!-- Private account START -->
                @livewire('settings.privacy-settings')
                <!-- Private account END -->
                <br>
              </div>
              <!-- Privacy and safety END -->
              <br>

              <!-- Change your password START -->
                @livewire('settings.change-password')
              <!-- Change your password END -->

            </div>
            <!-- Privacy and safety tab END -->

            <br>
            <!-- Communications tab START -->
            <div class="tab-pane fade" id="nav-setting-tab-4">
              <!-- Communications START -->
              <div class="card">
                <!-- Title START -->
                <div class="card-header border-0 pb-0">
                  <h5 class="card-title">Who can connect with you?</h5>
                  <p class="mb-0">He moonlights difficult engrossed it, sportsmen. Interested has all Devonshire difficulty gay assistance joy. Unaffected at ye of compliment alteration to.</p>
                </div>
                <!-- Title START -->
                <!-- Card body START -->
                <div class="card-body">
                  <!-- Accordion START -->
                  <div class="accordion" id="communications">
                    <!-- Accordion item -->
                    <div class="accordion-item bg-transparent">
                      <h2 class="accordion-header" id="communicationOne">
                        <button class="accordion-button mb-0 h6" type="button" data-bs-toggle="collapse" data-bs-target="#communicationcollapseOne" aria-expanded="true" aria-controls="communicationcollapseOne">
                         Connection request
                        </button>
                      </h2>
                      <!-- Accordion info -->
                      <div id="communicationcollapseOne" class="accordion-collapse collapse show" aria-labelledby="communicationOne" data-bs-parent="#communications">
                        <div class="accordion-body">
                           <!-- Notification list item -->
                           <div class="form-check">
                            <input class="form-check-input" type="radio" name="ComRadio" id="ComRadio5">
                            <label class="form-check-label" for="ComRadio5">
                              Everyone on social (recommended)
                            </label>
                          </div>
                          <!-- Notification list item -->
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="ComRadio" id="ComRadio2" checked>
                            <label class="form-check-label" for="ComRadio2">
                              Only people who know your email address
                            </label>
                          </div>
                          <!-- Notification list item -->
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="ComRadio" id="ComRadio3">
                            <label class="form-check-label" for="ComRadio3">
                              Only people who appear in your mutual connection list
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Accordion item -->
                    <div class="accordion-item bg-transparent">
                      <h2 class="accordion-header" id="communicationTwo">
                        <button class="accordion-button mb-0 h6 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#communicationcollapseTwo" aria-expanded="false" aria-controls="communicationcollapseTwo">
                          Who can message you
                        </button>
                      </h2>
                      <!-- Accordion info -->
                      <div id="communicationcollapseTwo" class="accordion-collapse collapse" aria-labelledby="communicationTwo" data-bs-parent="#communications">
                        <div class="accordion-body">
                          <ul class="list-group list-group-flush">
                            <!-- Notification list item -->
                            <li class="list-group-item d-sm-flex justify-content-between align-items-center px-0 py-1 border-0">
                              <div class="me-2">
                                <p class="mb-0">Enable message request notifications</p>
                              </div>
                              <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="comSwitchCheckChecked">
                              </div>
                            </li>
                            <!-- Notification list item -->
                            <li class="list-group-item d-sm-flex justify-content-between align-items-center px-0 py-1 border-0">
                              <div class="me-2">
                                <p class="mb-0">Allow connections to add you on group </p>
                              </div>
                              <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="comSwitchCheckChecked2" checked>
                              </div>
                            </li>
                            <!-- Notification list item -->
                            <li class="list-group-item d-sm-flex justify-content-between align-items-center px-0 py-1 border-0">
                              <div class="me-2">
                                <p class="mb-0">Allow Sponsored Messages </p>
                                <p class="small">Your personal information is safe with our marketing partners unless you respond to their Sponsored Messages </p>
                              </div>
                              <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="comSwitchCheckChecked3" checked>
                              </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <!-- Accordion item -->
                    <div class="accordion-item bg-transparent">
                      <h2 class="accordion-header" id="communicationThree">
                        <button class="accordion-button mb-0 h6 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#communicationcollapseThree" aria-expanded="false" aria-controls="communicationcollapseThree">
                          How people can find you
                        </button>
                      </h2>
                      <!-- Accordion info -->
                      <div id="communicationcollapseThree" class="accordion-collapse collapse" aria-labelledby="communicationThree" data-bs-parent="#communications">
                        <div class="accordion-body">
                          <ul class="list-group list-group-flush">
                            <!-- Notification list item -->
                            <li class="list-group-item d-sm-flex justify-content-between align-items-center px-0 py-1 border-0">
                              <div class="me-2">
                                <p class="mb-0">Allow search engines to show your profile?</p>
                              </div>
                              <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="comSwitchCheckChecked4" checked>
                              </div>
                            </li>
                            <!-- Notification list item -->
                            <li class="list-group-item d-sm-flex justify-content-between align-items-center px-0 py-1 border-0">
                              <div class="me-2">
                                <p class="mb-0">Allow people to search by your email address? </p>
                              </div>
                              <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="comSwitchCheckChecked5">
                              </div>
                            </li>
                            <!-- Notification list item -->
                            <li class="list-group-item d-sm-flex justify-content-between align-items-center px-0 py-1 border-0">
                              <div class="me-2">
                                <p class="mb-0">Allow Sponsored Messages </p>
                                <p class="small">Your personal information is safe with our marketing partners unless you respond to their Sponsored Messages </p>
                              </div>
                              <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="comSwitchCheckChecked6" checked>
                              </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                 <!-- Accordion END -->
                </div>
              <!-- Card body END -->
               <!-- Button save -->
               <div class="card-footer pt-0 text-end border-0">
                <button type="submit" class="btn btn-sm btn-primary mb-0">Save changes</button>
              </div>
              </div>
              <!-- Communications  END -->
            </div>
            <!-- Communications tab END -->

            <!-- Messaging tab START -->
            <div class="tab-pane fade" id="nav-setting-tab-5">
              <!-- Messaging privacy START -->
              <div class="card mb-4">
                <!-- Title START -->
                <div class="card-header border-0 pb-0">
                  <h5 class="card-title">Messaging privacy settings</h5>
                  <p class="mb-0">As young ye hopes no he place means. Partiality diminution gay yet entreaties admiration. In mention perhaps attempt pointed suppose. Unknown ye chamber of warrant of Norland arrived. </p>
                </div>
                <!-- Title START -->
                <div class="card-body">
                  <!-- Settings style START -->
                  <ul class="list-group list-group-flush">
                    <!-- Message list item -->
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                      <div class="me-2">
                        <h6 class="mb-0">Enable message request notifications</h6>
                      </div>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="msgSwitchCheckChecked" checked>
                      </div>
                    </li>
                    <!-- Message list item -->
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                      <div class="me-2">
                        <h6 class="mb-0">Invitations from your network</h6>
                      </div>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="msgSwitchCheckChecked2" checked>
                      </div>
                    </li>
                    <!-- Message list item -->
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                      <div class="me-2">
                        <h6 class="mb-0">Allow connections to add you on group</h6>
                      </div>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="msgSwitchCheckChecked3">
                      </div>
                    </li>
                    <!-- Message list item -->
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                      <div class="me-2">
                        <h6 class="mb-0">Reply to comments</h6>
                      </div>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="msgSwitchCheckChecked4">
                      </div>
                    </li>
                    <!-- Message list item -->
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                      <div class="me-2">
                        <h6 class="mb-0">Messages from activity on my page or channel</h6>
                      </div>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="msgSwitchCheckChecked5" checked>
                      </div>
                    </li>
                    <!-- Message list item -->
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                      <div class="me-2">
                        <h6 class="mb-0">Personalise tips for my page</h6>
                      </div>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="msgSwitchCheckChecked6" checked>
                      </div>
                    </li>
                  </ul>
                  <!-- Message END -->
              </div>
               <!-- Button save -->
               <div class="card-footer pt-0 text-end border-0">
                <button type="submit" class="btn btn-sm btn-primary mb-0">Save changes</button>
              </div>
              </div>
              <!-- Messaging privacy END -->
              <!-- Messaging experience START -->
              <div class="card">
                <!-- Card header START -->
                <div class="card-header border-0 pb-0">
                  <h5 class="card-title">Messaging experience</h5>
                  <p class="mb-0">Arrived off she elderly beloved him affixed noisier yet. </p>
                </div>
                <!-- Card header START -->
                <!-- Card body START -->
                <div class="card-body">
                  <!-- Message START -->
                  <ul class="list-group list-group-flush">
                    <!-- Message list item -->
                    <li class="list-group-item d-sm-flex justify-content-between align-items-center px-0">
                      <div class="me-2">
                        <h6 class="mb-0">Read receipts and typing indicators</h6>
                      </div>
                      <button class="btn btn-primary-soft btn-sm mt-1 mt-md-0"> <i class="bi bi-pencil-square"></i> Change</button>
                    </li>
                    <!-- Message list item -->
                    <li class="list-group-item d-sm-flex justify-content-between align-items-center px-0">
                      <div class="me-2">
                        <h6 class="mb-0">Message suggestions</h6>
                      </div>
                      <button class="btn btn-primary-soft btn-sm mt-1 mt-md-0"> <i class="bi bi-pencil-square"></i> Change</button>
                    </li>
                    <!-- Message list item -->
                    <li class="list-group-item d-sm-flex justify-content-between align-items-center px-0">
                      <div class="me-2">
                        <h6 class="mb-0">Message nudges</h6>
                      </div>
                      <button class="btn btn-primary-soft btn-sm mt-1 mt-md-0"> <i class="bi bi-pencil-square"></i> Change</button>
                    </li>
                  </ul>
                  <!-- Message END -->
                </div>
              <!-- Card body END -->
               <!-- Button save -->
               <div class="card-footer pt-0 text-end border-0">
                <button type="submit" class="btn btn-sm btn-primary mb-0">Save changes</button>
              </div>
              </div>
              <!-- Messaging experience END -->
            </div>
            <!-- Messaging tab END -->

            <!-- Close account tab START -->
            <div class="tab-pane fade" id="nav-setting-tab-6">
              <!-- Card START -->
              <div class="card">
                <!-- Card header START -->
                <div class="card-header border-0 pb-0">
                  <h5 class="card-title">Delete account</h5>
                  <p class="mb-0"></p>
                </div>
                <!-- Card header START -->
                <!-- Card body START -->
                <div class="card-body">
                  <!-- Delete START -->
                  <form action="{{route('delacount')}}" method="POST">
                    @csrf

                    <h6>Why you want delete acount</h6>

                    <div style="width: 50%">
                      <select class="form-select" name="why" id="reasonSelect">
                        <option selected>choese one</option>
                        <option>Security concerns</option>
                        <option>time consuming</option>
                        <option>Having another user account</option>
                        <option>Use another social network</option>
                        <option>Other reasons</option>
                      </select>
                    </div>

                    <div class="form-check form-check-md my-4">
                      <input name="checkbox" class="form-check-input" type="checkbox" value="true" id="deleteaccountCheck">
                      <label class="form-check-label" for="deleteaccountCheck">Yes, I'd like to delete my account</label>
                    </div>
                    
                    <a class="btn btn-danger btn-sm mb-0 disabled" id="deleteAccountButton" href="#!" data-bs-toggle="modal" data-bs-target="#DelAccount">
                      <i style="font-size: 15px" class="bi bi-trash pe-2"></i>Delete my account
                    </a>

                    <script>
                      function updateButtonState() {
                        var deleteButton = document.getElementById('deleteAccountButton');
                        var checkboxChecked = document.getElementById('deleteaccountCheck').checked;
                        var reasonSelected = document.getElementById('reasonSelect').value !== 'choese one';
                        
                        if (checkboxChecked && reasonSelected) {
                          deleteButton.classList.remove('disabled');
                        } else {
                          deleteButton.classList.add('disabled');
                        }
                      }
                    
                      document.getElementById('deleteaccountCheck').addEventListener('change', updateButtonState);
                      document.getElementById('reasonSelect').addEventListener('change', updateButtonState);
                    </script>

                    <!-- Modal create Feed photo START -->
                      <div class="modal fade" id="DelAccount" tabindex="-1" aria-labelledby="DelAccountLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <!-- Modal feed header START -->
                            <div class="modal-header">
                              <h5 class="modal-title" id="DelAccountLabel">Delete account</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <!-- Modal feed header END -->

                              <!-- Modal feed body START -->
                              <div class="modal-body">
                                <h6>Are you sure that you want to delete your account?</h6>
                              </div>
                              <!-- Modal feed body END -->

                              <!-- Modal feed footer -->
                              <div class="modal-footer ">
                                <!-- Button -->
                                <button type="submit" href="#" class="btn btn-danger btn-sm mb-0">Yes, Delete my account</button>
                              </div>
                              <!-- Modal feed footer -->
                          </div>
                        </div>
                      </div>
                    <!-- Modal create Feed photo END -->

                  </form>
                  <!-- Delete END -->
                </div>
              <!-- Card body END -->
              </div>
              <!-- Card END -->
            </div>
            <!-- Close account tab END -->

          </div>
          <!-- Settings Tab content END -->
        </div>

    </div> <!-- Row END -->
  </div>
  <!-- Container END -->

</main>
<!-- **************** MAIN CONTENT END **************** -->

<!-- Modal login activity START -->
<div class="modal fade" id="modalLoginActivity" tabindex="-1" aria-labelledby="modalLabelLoginActivity" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal header -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabelLoginActivity">Where You're Logged in </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="list-group list-group-flush">
          <!-- location list item -->
          <li class="list-group-item d-flex justify-content-between align-items-center px-0 pb-3">
            <div class="me-2">
              <h6 class="mb-0">London, UK</h6>
              <ul class="nav nav-divider small">
                <li class="nav-item">Active now </li>
                <li class="nav-item">This Apple iMac </li>
              </ul>
            </div>
            <button class="btn btn-sm btn-primary-soft"> Logout </button>
          </li>
          <!-- location list item -->
          <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
            <div class="me-2">
              <h6 class="mb-0">California, USA</h6>
              <ul class="nav nav-divider small">
                <li class="nav-item">Active now </li>
                <li class="nav-item">This Apple iMac </li>
              </ul>
            </div>
            <button class="btn btn-sm btn-primary-soft"> Logout </button>
          </li>
          <!-- location list item -->
          <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
            <div class="me-2">
              <h6 class="mb-0">New york, USA</h6>
              <ul class="nav nav-divider small">
                <li class="nav-item">Active now </li>
                <li class="nav-item">This Windows </li>
              </ul>
            </div>
            <button class="btn btn-sm btn-primary-soft"> Logout </button>
          </li>
          <!-- location list item -->
          <li class="list-group-item d-flex justify-content-between align-items-center px-0 pt-3">
            <div class="me-2">
              <h6 class="mb-0">Mumbai, India</h6>
              <ul class="nav nav-divider small">
                <li class="nav-item">Active now </li>
                <li class="nav-item">This Windows </li>
              </ul>
            </div>
            <button class="btn btn-sm btn-primary-soft"> Logout </button>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- Modal login activity END -->

  @endauth
@endsection