<a href="{{ route('restaurants.edit', $restaurant) }}">
    <div class="bg-white rounded-lg shadow p-4 pb-2 mb-3">
        <!-- Header section with name and rating -->
        <div class="flex justify-between items-start mb-1">
            <div class="flex-1 min-w-0">
                <h3 class="text-lg font-semibold text-gray-dark break-words">{{ $restaurant->name }}</h3>
                @if($restaurant->price_range)
                    <div class="text-sm font-medium text-gray-primary">
                        {{ $restaurant->price_range?->label() }}
                    </div>
                @endif
            </div>
            <div class="flex flex-col items-end flex-shrink-0 ml-4">
                @if($restaurant->rating)
                    <div class="flex items-center gap-0.5">
                        <span class="text-md font-medium text-gray-primary">{{ number_format($restaurant->rating, 1) }}</span>
                        <img src="{{ asset('app-icons/star-yellow.svg') }}" alt="Rating" class="w-5 h-5">
                    </div>
                @endif
            </div>
        </div>

        <!-- Location tags -->
        <div class="flex items-start gap-2 mb-2">
            <img src="{{ asset('app-icons/location-outline.svg') }}" alt="Location" class="w-4 h-4 mt-2">
            <div class="flex flex-wrap gap-1">
                <x-tags.main-location-tag :tag="$restaurant->mainLocationTag"/>
                @if($locationTags->isNotEmpty())
                    @foreach($locationTags as $tag)
                        <x-tags.restaurant-location-tag :tag="$tag" mode="readonly"/>
                    @endforeach
                @endif
            </div>
        </div>


        <!-- Other tags -->
        <div class="flex items-start gap-2 mb-2">
            <img src="{{ asset('app-icons/tag-outline.svg') }}" alt="Tags" class="w-4 h-4 mt-2">
            <div class="flex flex-wrap gap-1">
                <x-tags.main-tag :tag="$restaurant->mainTag"/>
                @if($otherTags->isNotEmpty())
                @foreach($otherTags as $tag)
                    <x-tags.restaurant-tag :tag="$tag" mode="readonly"/>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Description -->
        @if($restaurant->description)
            <div class="flex flex-col gap-2 mt-3">
                <p class="text-gray-600 whitespace-pre-line">{{ $restaurant->description }}</p>
            </div>
        @endif
    </div>
</a>
