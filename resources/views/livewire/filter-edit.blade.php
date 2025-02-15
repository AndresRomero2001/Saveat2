<div class="p-4 space-y-6">
    <form wire:submit="updateFilter" class="space-y-4">
        @csrf

        <!-- Name field -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') . "*"  }}</label>
            <input type="text" wire:model="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-blue focus:ring-primary-blue">
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Main tag field -->
        <div>
            <label for="main_tag_id" class="block text-sm font-medium text-gray-700">{{ __('Main tag') . "*" }}</label>
            <div class="relative mt-2">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        wire:model.live="mainTagSearch"
                        wire:focus="$set('mainTagSearchFocused', true)"
                        wire:blur="$set('mainTagSearchFocused', false)"
                        class="block w-full pl-9 rounded-md border-gray-300 shadow-sm focus:border-primary-blue focus:ring-primary-blue"
                        placeholder="{{ __('Search...') }}"
                    >
                </div>

                @if($mainTagSearch && $mainTagSearchFocused)
                    <div class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-sm">
                        @forelse($searchedMainTags as $tag)
                            <button
                                type="button"
                                wire:click="setMainTag({{ $tag->id }})"
                                class="w-full px-3 py-2 text-left text-sm hover:bg-gray-50"
                            >
                                {{ $tag->name }}
                            </button>
                        @empty
                            <div class="flex items-center justify-between px-3 py-2">
                                <span class="text-sm text-gray-500">{{ __('No tags found') }}</span>
                                <button
                                    type="button"
                                    wire:click="openCreateTagModal('main')"
                                    class="text-sm text-primary-blue hover:text-primary-blue-dark font-medium"
                                >
                                    {{ __('Create') }}
                                </button>
                            </div>
                        @endforelse
                    </div>
                @endif
            </div>

            @if($selectedMainTag)
                <div class="mt-2">
                    <x-tags.main-removable-tag :tag="$selectedMainTag" />
                </div>
            @endif
            @error('main_tag_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Main location field -->
        <div>
            <label for="main_location_tag_id" class="block text-sm font-medium text-gray-700">{{ __('Main location') . "*"  }}</label>
            <div class="relative mt-2">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        wire:model.live="locationTagSearch"
                        wire:focus="$set('locationTagSearchFocused', true)"
                        wire:blur="$set('locationTagSearchFocused', false)"
                        class="block w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-primary-blue focus:ring-primary-blue"
                        placeholder="{{ __('Search...') }}"
                    >
                </div>

                @if($locationTagSearch && $locationTagSearchFocused)
                    <div class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-sm">
                        @forelse($searchedLocationTags as $tag)
                            <button
                                type="button"
                                wire:click="setLocationTag({{ $tag->id }})"
                                class="w-full px-3 py-2 text-left text-sm hover:bg-gray-50"
                            >
                                {{ $tag->name }}
                            </button>
                        @empty
                            <div class="flex items-center justify-between px-3 py-2">
                                <span class="text-sm text-gray-500">{{ __('No tags found') }}</span>
                                <button
                                    type="button"
                                    wire:click="openCreateTagModal('location')"
                                    class="text-sm text-primary-blue hover:text-primary-blue-dark font-medium"
                                >
                                    {{ __('Create') }}
                                </button>
                            </div>
                        @endforelse
                    </div>
                @endif
            </div>

            @if($selectedLocationTag)
                <div class="mt-2">
                    <x-tags.main-removable-tag :tag="$selectedLocationTag" />
                </div>
            @endif
            @error('main_location_tag_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Tags field -->
        <div>
            <label for="tags" class="block text-sm font-medium text-gray-700">{{ __('Tags') }}</label>
            <div class="relative mt-2">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input
                    type="text"
                    wire:model.live="tagSearch"
                    wire:focus="$set('tagSearchFocused', true)"
                    wire:blur="$set('tagSearchFocused', false)"
                    class="block w-full pl-9 rounded-md border-gray-300 shadow-sm focus:border-primary-blue focus:ring-primary-blue"
                    placeholder="{{ __('Search...') }}"
                >

                @if($tagSearch && $tagSearchFocused)
                    <div class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-sm">
                        @forelse($searchedTags as $tag)
                            <button
                                type="button"
                                wire:click="addTag({{ $tag->id }})"
                                class="w-full px-3 py-2 text-left text-sm hover:bg-gray-50"
                            >
                                {{ $tag->name }}
                            </button>
                        @empty
                            <div class="flex items-center justify-between px-3 py-2">
                                <span class="text-sm text-gray-500">{{ __('No tags found') }}</span>
                                <button
                                    type="button"
                                    wire:click="openCreateTagModal('tag')"
                                    class="text-sm text-primary-blue hover:text-primary-blue-dark font-medium"
                                >
                                    {{ __('Create') }}
                                </button>
                            </div>
                        @endforelse
                    </div>
                @endif
            </div>

            @if($selectedTags->isNotEmpty())
                <div class="mt-2 flex flex-wrap gap-1">
                    @foreach($selectedTags as $tag)
                        <x-tags.removable-tag :tag="$tag" />
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Price Range -->
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('Price Range') }}</label>
            <div class="grid grid-cols-2 gap-2 mt-2">
                @foreach(\App\Enums\PriceRange::cases() as $priceRange)
                    <button
                        type="button"
                        wire:click="togglePriceRange('{{ $priceRange->value }}')"
                        class="py-2 px-3 rounded-lg border {{ in_array($priceRange->value, $priceRanges) ? 'bg-primary-blue text-white border-primary-blue' : 'border-gray-300' }}"
                    >
                        {{ $priceRange->label() }}
                    </button>
                @endforeach
            </div>
            @error('priceRanges') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Rating -->
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('Rating') }}</label>
            <div class="mt-2">
                <livewire:star-rating-input :value="$rating ?? 0" />
            </div>
            @error('rating') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between gap-2">
            <button
                type="button"
                wire:click="$set('showDeleteModal', true)"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
            >
                {{ __('Delete') }}
            </button>
            <div class="flex gap-2">
                <a
                    href="{{ route('filters.index') }}"
                    class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-blue"
                >
                    {{ __('Cancel') }}
                </a>
                <button
                    type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-blue hover:bg-primary-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-blue"
                >
                    {{ __('Save') }}
                </button>
            </div>
        </div>
    </form>


    <!-- Delete Modal -->
    @if($showDeleteModal)
        <div
            class="fixed inset-0 bg-gray-500 bg-opacity-75 z-50"
            wire:click="$set('showDeleteModal', false)"
        >
            <div class="flex min-h-full items-center justify-center p-4">
                <div
                    class="bg-white rounded-lg overflow-hidden shadow-xl transform w-full max-w-lg"
                    wire:click.stop="$refresh"
                >
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Delete Filter') }}
                        </h2>
                        <p class="mt-3 text-sm text-gray-600">
                            {{ __('Are you sure you want to delete this filter? This action cannot be undone.') }}
                        </p>
                        <div class="mt-6 flex justify-end gap-3">
                            <button
                                type="button"
                                wire:click="$set('showDeleteModal', false)"
                                class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200"
                            >
                                {{ __('Cancel') }}
                            </button>
                            <button
                                type="button"
                                wire:click="deleteFilter"
                                class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700"
                            >
                                {{ __('Delete') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Create Tag Modal -->
    @if($showCreateTagModal)
        <div
            class="fixed inset-0 bg-gray-500 bg-opacity-75 z-50"
            wire:click="$set('showCreateTagModal', false)"
        >
            <div class="fixed inset-0 z-50 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4">
                    <div
                        class="w-full max-w-md bg-white rounded-xl p-4"
                        wire:click.stop="$refresh"
                    >
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold">{{ __('Create Tag') }}</h2>
                            <button wire:click="$set('showCreateTagModal', false)">
                                <img src="{{ asset('app-icons/delete.svg') }}" alt="Close" class="w-6 h-6">
                            </button>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                                <input
                                    type="text"
                                    wire:model="newTagName"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-blue focus:ring-primary-blue"
                                >
                            </div>

                            <div>
                                <div class="mt-1">
                                    <label class="flex items-center">
                                        <input
                                            type="checkbox"
                                            wire:model="newTagIsLocation"
                                            class="rounded border-gray-300 text-primary-blue focus:ring-primary-blue"
                                        >
                                        <span class="ml-2 text-sm text-gray-600">{{ __('It is a location') }}</span>
                                    </label>
                                </div>
                            </div>

                            <div class="flex justify-end gap-2">
                                <button
                                    wire:click="$set('showCreateTagModal', false)"
                                    class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200"
                                >
                                    {{ __('Cancel') }}
                                </button>
                                <button
                                    wire:click="createTag"
                                    class="px-4 py-2 text-white bg-primary-blue rounded-lg hover:bg-primary-blue-dark"
                                >
                                    {{ __('Create') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

