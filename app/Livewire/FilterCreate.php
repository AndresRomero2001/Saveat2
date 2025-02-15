<?php

namespace App\Livewire;

use App\Models\Filter;
use App\Models\Tag;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;

class FilterCreate extends Component
{
    public $name = '';
    public $rating = 0;
    public $priceRanges = [];
    public $tagIds = [];
    public $mainTagId = null;
    public $mainLocationTagId = null;
    public $tagSearch = '';
    public $mainTagSearch = '';
    public $locationTagSearch = '';
    public $selectedMainTag = null;
    public $selectedLocationTag = null;
    public $mainTagSearchFocused = false;
    public $locationTagSearchFocused = false;
    public $tagSearchFocused = false;
    public Collection $selectedTags;
    public $showCreateTagModal = false;
    public $newTagName = '';
    public $newTagIsLocation = false;
    public $createTagType = '';

    public function mount()
    {
        $this->selectedTags = collect();
    }

    // Keep all the existing methods from Filters.php except loadFilters() and deleteFilter()

    public function createFilter()
    {
        $this->validate([
            'name' => [
                'required',
                'string',
                'max:32',
                Filter::uniqueNameRule()
            ],
        ]);

        $filter = Auth::user()->filters()->create([
            'name' => $this->name,
            'rating' => $this->rating,
            'price_ranges' => $this->priceRanges,
            'main_tag_id' => $this->mainTagId,
            'main_location_tag_id' => $this->mainLocationTagId,
        ]);

        $filter->tags()->attach($this->tagIds);

        return redirect()->route('filters.index');
    }

    public function togglePriceRange($range)
    {
        if (in_array($range, $this->priceRanges)) {
            $this->priceRanges = array_diff($this->priceRanges, [$range]);
        } else {
            $this->priceRanges[] = $range;
        }
    }

    public function setMainTag($tagId)
    {
        $tag = Tag::find($tagId);
        $this->selectedMainTag = $tag;
        $this->mainTagId = $tagId;
        $this->mainTagSearch = '';
        $this->mainTagSearchFocused = false;
    }

    public function setLocationTag($tagId)
    {
        $tag = Tag::find($tagId);
        $this->selectedLocationTag = $tag;
        $this->mainLocationTagId = $tagId;
        $this->locationTagSearch = '';
        $this->locationTagSearchFocused = false;
    }

    public function addTag($tagId)
    {
        if (!in_array($tagId, $this->tagIds)) {
            $this->tagIds[] = $tagId;
            $this->selectedTags->push(Tag::find($tagId));
        }
        $this->tagSearch = '';
        $this->tagSearchFocused = false;
    }

    public function removeTag($tagId)
    {
        $this->tagIds = array_diff($this->tagIds, [$tagId]);
        $this->selectedTags = $this->selectedTags->reject(fn($tag) => $tag->id === $tagId);
    }

    public function openCreateTagModal($source)
    {
        $this->createTagType = $source;

        switch ($source) {
            case 'main':
                $this->newTagName = $this->mainTagSearch;
                $this->newTagIsLocation = false;
                break;
            case 'location':
                $this->newTagName = $this->locationTagSearch;
                $this->newTagIsLocation = true;
                break;
            default:
                $this->newTagName = $this->tagSearch;
                $this->newTagIsLocation = false;
        }

        $this->showCreateTagModal = true;
    }

    public function createTag()
    {
        $tag = Tag::create([
            'name' => $this->newTagName,
            'user_id' => Auth::id(),
            'is_location' => $this->newTagIsLocation
        ]);

        switch ($this->createTagType) {
            case 'main':
                $this->setMainTag($tag->id);
                break;
            case 'location':
                $this->setLocationTag($tag->id);
                break;
            case 'tag':
                $this->addTag($tag->id);
                break;
        }

        $this->showCreateTagModal = false;
        $this->newTagName = '';
        $this->newTagIsLocation = false;
        $this->createTagType = '';
    }

    public function getSearchedMainTagsProperty()
    {
        if (!$this->mainTagSearch) {
            return collect();
        }

        return Tag::visibleToUser(Auth::id())
            ->where('name', 'like', "%{$this->mainTagSearch}%")
            ->where('is_location', false)
            ->limit(5)
            ->get();
    }

    public function getSearchedLocationTagsProperty()
    {
        if (!$this->locationTagSearch) {
            return collect();
        }

        return Tag::visibleToUser(Auth::id())
            ->where('name', 'like', "%{$this->locationTagSearch}%")
            ->where('is_location', true)
            ->limit(5)
            ->get();
    }

    public function getSearchedTagsProperty()
    {
        if (!$this->tagSearch) {
            return collect();
        }

        return Tag::visibleToUser(Auth::id())
            ->where('name', 'like', "%{$this->tagSearch}%")
            ->whereNotIn('id', $this->tagIds)
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.filter-create', [
            'searchedMainTags' => Tag::visibleToUser(Auth::id())
                ->where('name', 'like', "%{$this->mainTagSearch}%")
                ->where('is_location', false)
                ->limit(5)
                ->get(),
            'searchedLocationTags' => Tag::visibleToUser(Auth::id())
                ->where('name', 'like', "%{$this->locationTagSearch}%")
                ->where('is_location', true)
                ->limit(5)
                ->get(),
            'searchedTags' => Tag::visibleToUser(Auth::id())
                ->where('name', 'like', "%{$this->tagSearch}%")
                ->whereNotIn('id', $this->tagIds)
                ->limit(5)
                ->get(),
        ]);
    }

    public function removeMainTag()
    {
        $this->mainTagId = null;
        $this->selectedMainTag = null;
    }

    public function removeLocationTag()
    {
        $this->mainLocationTagId = null;
        $this->selectedLocationTag = null;
    }

    #[On('rating-changed')]
    public function handleRatingChange($value)
    {
        $this->rating = $value;
    }
}
