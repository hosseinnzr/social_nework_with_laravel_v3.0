<div wire:poll.visible>
    @if ($saved)
        <button wire:click="deleteSave({{$post}})">
            <i class="bi bi-bookmark-fill fa-xl pe-2"></i>
        </button>
    @else
        <button wire:click="savepost({{$post}})">
            <i class="bi bi-bookmark fa-xl pe-2"></i>
        </button>
    @endif
</div>
