<div>
    <div wire:poll.visible style="text-align: center">
        @if ($liked)
            <button wire:click="dislike({{$story}})" style="color: red; position: absolute; bottom: 4%; right: 6%; font-size: 27px;" class="btn btn-sm "><i class="bi bi-heart-fill fs-20"></i></button>
        @else
            <button wire:click="like({{$story}})" style="color: rgb(164, 164, 164); position: absolute; bottom: 4%; right: 6%; font-size: 27px;" class="btn btn-sm "><i class="bi bi-heart fs-20"></i></button>
        @endif
    </div>
</div>
