<?php

namespace App\Livewire;

use App\Models\Filter;
use App\Models\Tag;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class Filters extends Component
{
    public $filters;
    public $isCreating = false;

    public function mount()
    {
        $this->loadFilters();
    }

    public function loadFilters()
    {
        $this->filters = Auth::user()->filters()->get();
    }

    public function render()
    {
        return view('livewire.filters');
    }
}
