<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Filter;
class FilterController extends Controller
{
    public function index(): View
    {
        $tags = Tag::orderBy('name')->get();
        return view('filters.index', compact('tags'));
    }

    public function create(): View
    {
        return view('filters.create');
    }

    public function edit(Filter $filter): View
    {
        return view('filters.edit', compact('filter'));
    }
}
