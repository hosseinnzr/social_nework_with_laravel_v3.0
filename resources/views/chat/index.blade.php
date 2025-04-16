@extends('chat.layoutChat')
@section('title', 'chat')
@section('content')
@auth

{{ csrf_field() }}


<main>
  
  <!-- Container START -->
  <div class="container">

      <!-- Chat START -->
        @livewire('show-user-chat', ['chat' => $chat])
      <!-- Chat START -->

	</div>
  <!-- Container END -->

</main>


@endauth

@endsection    