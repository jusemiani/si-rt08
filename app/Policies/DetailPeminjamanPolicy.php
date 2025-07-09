<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DetailPeminjaman;
use Illuminate\Auth\Access\Response;

class DetailPeminjamanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('View Any DetailPeminjaman');
    }

    public function view(User $user, DetailPeminjaman $model): bool
    {
        return $user->can('View DetailPeminjaman');
    }

    public function create(User $user): bool
    {
        return $user->can('Create DetailPeminjaman');
    }

    public function update(User $user, DetailPeminjaman $model): bool
    {
        return $user->can('Update DetailPeminjaman');
    }

    public function delete(User $user, DetailPeminjaman $model): bool
    {
        return $user->can('Delete DetailPeminjaman');
    }

    public function restore(User $user, DetailPeminjaman $model): bool
    {
        return $user->can('Restore DetailPeminjaman');
    }

    public function forceDelete(User $user, DetailPeminjaman $model): bool
    {
        return $user->can('Force Delete DetailPeminjaman');
    }
}
