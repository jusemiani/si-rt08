<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Pemasukan;
use Illuminate\Auth\Access\Response;

class PemasukanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('View Any Pemasukan');
    }

    public function view(User $user, Pemasukan $model): bool
    {
        return $user->can('View Pemasukan');
    }

    public function create(User $user): bool
    {
        return $user->can('Create Pemasukan');
    }

    public function update(User $user, Pemasukan $model): bool
    {
        return $user->can('Update Pemasukan');
    }

    public function delete(User $user, Pemasukan $model): bool
    {
        return $user->can('Delete Pemasukan');
    }

    public function restore(User $user, Pemasukan $model): bool
    {
        return $user->can('Restore Pemasukan');
    }

    public function forceDelete(User $user, Pemasukan $model): bool
    {
        return $user->can('Force Delete Pemasukan');
    }
}