<?php

namespace App\Livewire;

use App\Models\Restaurant;
use App\Models\Tag;
use App\Models\Filter;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
class RestaurantManager extends Component
{
    public $restaurants;
    public $search = '';
    public $showFilters = false;
    public $tagSearch = '';
    public Collection $selectedTags;
    public $filters = [
        'rating' => 0,
        'price_ranges' => [],
        'tag_ids' => [],
        'main_tag_id' => null,
        'main_location_tag_id' => null
    ];
    public $mainTagSearch = '';
    public $locationTagSearch = '';
    public $mainTagSearchFocused = false;
    public $locationTagSearchFocused = false;
    public $tagSearchFocused = false;
    public $selectedMainTag = null;
    public $selectedLocationTag = null;
    public $activeFilters = [
        'rating' => 0,
        'price_ranges' => [],
        'tag_ids' => [],
        'main_tag_id' => null,
        'main_location_tag_id' => null
    ];

    public function mount()
    {
        $this->restaurants = collect();
        $this->selectedTags = collect();

        $filter_id = session('apply_filter_id');

        if ($filter_id) {
            $this->setSavedFilters($filter_id);
            $this->activeFilters = $this->filters;
        }

        $this->loadRestaurants();
    }

    #[On('search-updated')]
    public function handleSearch($search)
    {
        $this->search = $search;
        $this->loadRestaurants();
    }

    public function addTag($tagId)
    {
        $tag = Tag::find($tagId);

        if (!$this->selectedTags->contains('id', $tagId)) {
            $this->selectedTags->push($tag);
            $this->filters['tag_ids'][] = $tagId;
        }

        $this->tagSearch = '';
    }

    public function removeTag($tagId)
    {
        $this->selectedTags = $this->selectedTags->reject(fn($t) => $t->id === $tagId);
        $this->filters['tag_ids'] = array_values(array_diff($this->filters['tag_ids'], [$tagId]));
    }

    public function togglePriceRange($priceRange)
    {
        if (in_array($priceRange, $this->filters['price_ranges'])) {
            $this->filters['price_ranges'] = array_values(
                array_diff($this->filters['price_ranges'], [$priceRange])
            );
        } else {
            $this->filters['price_ranges'][] = $priceRange;
        }
    }

    public function applyFilters()
    {
        $this->activeFilters = $this->filters;
        $this->showFilters = false;
        $this->loadRestaurants();
    }

    public function loadRestaurants()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $query = Restaurant::with(['mainTag', 'mainLocationTag', 'tags'])
            ->where('restaurants.user_id', Auth::id())
            ->orderBy('restaurants.name');

        if ($this->search) {
            $query->where('restaurants.name', 'like', '%' . $this->search . '%');
        }

        if ($this->filters['rating'] > 0) {
            $query->where('restaurants.rating', '>=', $this->filters['rating']);
        }

        if (!empty($this->filters['price_ranges'])) {
            $query->whereIn('restaurants.price_range', $this->filters['price_ranges']);
        }

        // Handle main tag filter
        if ($this->filters['main_tag_id']) {
            $query->where('main_tag_id', $this->filters['main_tag_id']);
        }

        // Handle location tag filter
        if ($this->filters['main_location_tag_id']) {
            $query->where('main_location_tag_id', $this->filters['main_location_tag_id']);
        }

        // Handle other tags filter
        if (!empty($this->filters['tag_ids'])) {
            $query->whereHas('tags', function ($q) {
                $q->whereIn('tags.id', $this->filters['tag_ids']);
            });
        }

        $this->restaurants = $query->get();
    }

    public function render()
    {
        return view('livewire.restaurant-manager', [
            'searchedMainTags' => $this->getSearchedMainTag(),
            'searchedLocationTags' => $this->getSearchedMainLocationTag(),
            'searchedTags' => $this->getSearchedTags()
        ]);
    }

    public function clearFilters()
    {
        $this->filters = [
            'rating' => 0,
            'price_ranges' => [],
            'tag_ids' => [],
            'main_tag_id' => null,
            'main_location_tag_id' => null
        ];
        $this->selectedTags = collect();
        $this->selectedMainTag = null;
        $this->selectedLocationTag = null;
        $this->dispatch('rating-reset');
    }

    #[On('rating-changed')]
    public function handleRatingChange($value)
    {
        $this->filters['rating'] = $value;
    }

    public function hasActiveFilters()
    {
        return $this->activeFilters['rating'] > 0
            || !empty($this->activeFilters['price_ranges'])
            || !empty($this->activeFilters['tag_ids'])
            || $this->activeFilters['main_tag_id']
            || $this->activeFilters['main_location_tag_id'];
    }

    public function setMainTag($tagId)
    {
        $tag = Tag::find($tagId);
        $this->filters['main_tag_id'] = $tagId;
        $this->selectedMainTag = $tag;
        $this->mainTagSearch = '';
    }

    public function removeMainTag()
    {
        $this->filters['main_tag_id'] = null;
        $this->selectedMainTag = null;
    }

    public function setLocationTag($tagId)
    {
        $tag = Tag::find($tagId);
        $this->filters['main_location_tag_id'] = $tagId;
        $this->selectedLocationTag = $tag;
        $this->locationTagSearch = '';
    }

    public function removeLocationTag()
    {
        $this->filters['main_location_tag_id'] = null;
        $this->selectedLocationTag = null;
    }

    protected function getSearchedTags()
    {
        return Tag::visibleToUser(Auth::id())
            ->where('name', 'like', "%{$this->tagSearch}%")
            ->limit(5)
            ->get();
    }

    protected function getSearchedMainTag()
    {
        return Tag::visibleToUser(Auth::id())
            ->where('name', 'like', "%{$this->mainTagSearch}%")
            ->where('is_location', false)
            ->limit(5)
            ->get();
    }

    protected function getSearchedMainLocationTag()
    {
        return Tag::visibleToUser(Auth::id())
            ->where('name', 'like', "%{$this->locationTagSearch}%")
            ->where('is_location', true)
            ->limit(5)
            ->get();
    }

    public function setSavedFilters($filterId)
    {
        $filter = Filter::findOrFail($filterId);

        $this->filters = [
            'rating' => $filter->rating,
            'price_ranges' => $filter->price_ranges ?? [],
            'tag_ids' => $filter->tag_ids ?? [],
            'main_tag_id' => $filter->main_tag_id,
            'main_location_tag_id' => $filter->main_location_tag_id,
        ];

        // Update selected tags
        $this->selectedTags = Tag::whereIn('id', $this->filters['tag_ids'])->get();
        $this->selectedMainTag = $filter->mainTag;
        $this->selectedLocationTag = $filter->mainLocationTag;
    }

    public function openFiltersModal()
    {
        // Restore active filters when opening modal
        if ($this->hasActiveFilters()) {
            $this->filters = $this->activeFilters;
            $this->selectedTags = Tag::whereIn('id', $this->activeFilters['tag_ids'])->get();
            $this->selectedMainTag = Tag::find($this->activeFilters['main_tag_id']);
            $this->selectedLocationTag = Tag::find($this->activeFilters['main_location_tag_id']);
        }
        $this->showFilters = true;
    }
}
