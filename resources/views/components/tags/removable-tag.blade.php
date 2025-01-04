@props(['tag'])

<div class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-sm bg-white border {{ $tag->is_location ? 'border-primary-blue' : 'border-amber-700' }}">
    <span>{{ $tag->name }}</span>
    <button
        type="button"
        wire:click="removeTag({{ $tag->id }})"
        class="text-gray-400 hover:text-gray-600"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
