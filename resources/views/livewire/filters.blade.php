<div class="">
    <div class="space-y-4">
        @forelse($filters as $filter)
            <livewire:filter :filter="$filter" :key="$filter->id" />
        @empty
            <div class="text-center text-gray-500 py-8">
                {{ __('No saved filters yet') }}
            </div>
        @endforelse
    </div>

    <!-- Create Button -->
    <div class="fixed bottom-20 right-4">
        <a
            href="{{ route('filters.create') }}"
            class="flex items-center justify-center w-12 h-12 text-white bg-primary-blue rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-blue shadow-lg"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </a>
    </div>
</div>
