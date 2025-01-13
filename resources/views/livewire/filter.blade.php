<div class="bg-white rounded-lg shadow p-4 pb-2 mb-3">
    <a href="{{ route('filters.edit', $filter) }}">
        <!-- Header section with name and rating -->
        <div class="flex justify-between items-start mb-2">
            <div class="flex-1 min-w-0">
                <h3 class="text-lg font-semibold text-gray-dark break-words">{{ $filter->name }}</h3>
                @if($filter->price_ranges)
                    <div class="text-sm font-medium text-gray-primary">
                        @foreach($filter->price_ranges as $range)
                            {{ \App\Enums\PriceRange::from($range)->label() }}
                            @if(!$loop->last), @endif
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="flex flex-col items-end flex-shrink-0 ml-4">
                @if($filter->rating)
                    <div class="flex items-center gap-0.5">
                        <span class="text-md font-medium text-gray-primary">≥ {{ $filter->rating }}</span>
                        <img src="{{ asset('app-icons/star-yellow.svg') }}" alt="Rating" class="w-5 h-5">
                    </div>
                @endif
            </div>
        </div>

        <!-- Location tags -->
        @if($filter->mainLocationTag || $locationTags->isNotEmpty())
            <div class="flex items-start gap-2 mb-2">
                <img src="{{ asset('app-icons/location-outline.svg') }}" alt="Location" class="w-4 h-4 mt-2">
                <div class="flex flex-wrap gap-1">
                    @if($filter->mainLocationTag)
                        <x-tags.main-location-tag :tag="$filter->mainLocationTag"/>
                    @endif
                    @if($locationTags && $locationTags->isNotEmpty())
                        @foreach($locationTags as $tag)
                            <x-tags.restaurant-location-tag :tag="$tag" mode="readonly"/>
                        @endforeach
                    @endif
                </div>
            </div>
        @endif

        <!-- Other tags -->
        @if($filter->mainTag || $otherTags->isNotEmpty())
            <div class="flex items-start gap-2 mb-2">
                <img src="{{ asset('app-icons/tag-outline.svg') }}" alt="Tags" class="w-4 h-4 mt-2">
                <div class="flex flex-wrap gap-1">
                    @if($filter->mainTag)
                        <x-tags.main-tag :tag="$filter->mainTag"/>
                    @endif
                    @if($otherTags && $otherTags->isNotEmpty())
                        @foreach($otherTags as $tag)
                            <x-tags.restaurant-tag :tag="$tag" mode="readonly"/>
                        @endforeach
                    @endif
                </div>
            </div>
        @endif
    </a>

    <!-- Apply button outside of the <a> tag -->
    <div class="flex justify-end mt-2 mb-2">
        <button
            wire:click="applyFilter"
            class="px-4 py-2 text-white bg-primary-blue rounded-lg hover:bg-primary-blue-dark text-sm"
        >
            {{ __('Search') }}
        </button>
    </div>
</div>
