<?php

namespace App\Livewire;

use App\Models\Filter as FilterModel;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
class Filter extends Component
{
    public FilterModel $filter;
    public Collection $locationTags;
    public Collection $otherTags;

    public function mount(FilterModel $filter)
    {
        $this->filter = $filter;
        $this->locationTags = $this->filter->tags
            ->where('is_location', true)
            ->where('id', '!=', $this->filter->main_location_tag_id);
        $this->otherTags = $this->filter->tags
            ->where('is_location', false)
            ->where('id', '!=', $this->filter->main_tag_id);
    }

    public function applyFilter()
    {
        session()->flash('apply_filter_id', $this->filter->id);
        return redirect()->route('restaurants.index');
    }

    public function render()
    {
        return view('livewire.filter');
    }
}
