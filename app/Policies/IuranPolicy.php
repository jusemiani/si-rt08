<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Iuran;
use Illuminate\Auth\Access\Response;

class IuranPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('View Any Iuran');
    }

    public function view(User $user, Iuran $model): bool
    {
        return $user->can('View Iuran');
    }

    public function create(User $user): bool
    {
        return $user->can('Create Iuran');
    }

    public function update(User $user, Iuran $model): bool
    {
        return $user->can('Update Iuran');
    }

    public function delete(User $user, Iuran $model): bool
    {
        return $user->can('Delete Iuran');
    }

    public function restore(User $user, Iuran $model): bool
    {
        return $user->can('Restore Iuran');
    }

    public function forceDelete(User $user, Iuran $model): bool
    {
        return $user->can('Force Delete Iuran');
    }
}