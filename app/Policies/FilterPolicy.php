<?php

namespace App\Policies;

use App\Models\Filter;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FilterPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Allow authenticated users to view their filters index
    }

    public function view(User $user, Filter $filter): bool
    {
        return $user->id === $filter->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Filter $filter): bool
    {
        return $user->id === $filter->user_id;
    }

    public function delete(User $user, Filter $filter): bool
    {
        return $user->id === $filter->user_id;
    }
}
