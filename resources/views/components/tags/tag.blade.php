@props(['tag', 'mode' => 'editable'])

<div class="inline-flex bg-white rounded-md py-1 px-2 text-sm border {{ $tag->is_location ? 'border-primary-blue' : 'border-amber-700' }}">

        @if ($mode === 'editable' && !$tag->is_default)
            <button
                type="button"
                class="text-gray-700 hover:text-gray-900 focus:outline-none mr-1"
                wire:click="editTag({{ $tag->id }})"
            >
                {{ $tag->name }}
            </button>

            <button
                type="button"
                class="text-gray-400 hover:text-gray-600 focus:outline-none"
                wire:click="confirmDelete({{ $tag->id }})"
            >
                <span class="text-gray-primary-dark">
                    <img src="{{ asset('app-icons/delete.svg') }}" alt="Delete" class="w-2.5 h-2.5">
                </span>
            </button>
        @else
            <div class="flex items-center">
                <span class="text-gray-700">{{ $tag->name }}</span>
            </div>
        @endif

</div>
