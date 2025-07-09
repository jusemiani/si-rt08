<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Auth\Access\Response;

class PeminjamanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('View Any Peminjaman');
    }

    public function view(User $user, Peminjaman $model): bool
    {
        return $user->can('View Peminjaman');
    }

    public function create(User $user): bool
    {
        return $user->can('Create Peminjaman');
    }

    public function update(User $user, Peminjaman $model): bool
    {
        return $user->can('Update Peminjaman');
    }

    public function delete(User $user, Peminjaman $model): bool
    {
        return $user->can('Delete Peminjaman');
    }

    public function restore(User $user, Peminjaman $model): bool
    {
        return $user->can('Restore Peminjaman');
    }

    public function forceDelete(User $user, Peminjaman $model): bool
    {
        return $user->can('Force Delete Peminjaman');
    }
}