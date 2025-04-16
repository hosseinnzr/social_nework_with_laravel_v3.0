@extends('layout')
@section('title', "home page")
@section('content')
    {{ csrf_field() }}
<main>
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-sm-10 col-md-8 col-lg-6 col-xl-6 col-xxl-5">
        <div class="card card-body rounded-3 p-4 p-sm-5">
          
          @livewire('signup')

        </div>
      </div>
    </div>
  </div>
</main>
@endsection