<div wire:init="poll" wire:poll.2000ms="poll" class="p-3 border rounded">
    <div class="text-sm">Status: <span class="font-semibold">{{ $status }}</span></div>
    @if(!is_null($progress))
        <div class="mt-2 w-full bg-gray-200 h-2 rounded">
            <div class="bg-blue-600 h-2 rounded" style="width: {{ $progress }}%"></div>
        </div>
        <div class="text-xs mt-1">{{ $progress }}%</div>
    @endif
    @if($attached)
        <div class="text-xs text-green-700 mt-2">Video attached to lesson.</div>
    @endif
</div>


