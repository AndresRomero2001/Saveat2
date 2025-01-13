<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class Filter extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'rating',
        'price_ranges',
        'main_tag_id',
        'main_location_tag_id',
        'tag_ids',
    ];

    protected $casts = [
        'price_ranges' => 'array',
        'tag_ids' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mainTag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'main_tag_id');
    }

    public function mainLocationTag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'main_location_tag_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'filter_tag')
            ->withTimestamps();
    }

    public static function uniqueNameRule($ignoreId = null)
    {
        return function ($attribute, $value, $fail) use ($ignoreId) {
            $query = Filter::where('name', $value)
                ->where('user_id', Auth::id());

            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }

            if ($query->exists()) {
                $fail(__('You already have a filter with this name.'));
            }
        };
    }
}
