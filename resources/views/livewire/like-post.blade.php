<div wire:poll.visible style="text-align: center">
    @if ($liked)
        <button style="color:red;" wire:click="dislike({{$post}})"><i class="bi bi-heart-fill fa-lg pe-1"></i> {{ $post['like_number'] }}</button>
    @else
        <button  wire:click="like({{$post}})"><i class="bi bi-heart fa-lg pe-1"></i> {{ $post['like_number'] }}</button>
    @endif
</div>