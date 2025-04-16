@extends('layout')
@section('title', 'forget password')
@section('content')

<main>
  
  <!-- Container START -->
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <!-- Main content START -->
      <div class="col-sm-10 col-md-8 col-lg-7 col-xl-6 col-xxl-5">
        <!-- Sign in START -->
        <div class="card card-body p-4 p-sm-5">
          <!-- Title -->
          <h1 class="mb-2 text-center">Forget password</h1>
          <p class="text-center">back to <a href="/signin"> sign in</a> page</p>
          <!-- Form START -->

            @livewire('forget-password')

          <!-- Form END -->
        </div>
        <!-- Sign in START -->
      </div>
    </div> <!-- Row END -->
  </div>
  <!-- Container END -->

</main>

@endsection
