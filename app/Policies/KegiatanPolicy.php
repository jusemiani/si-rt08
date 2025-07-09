<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Kegiatan;
use Illuminate\Auth\Access\Response;

class KegiatanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('View Any Kegiatan');
    }

    public function view(User $user, Kegiatan $model): bool
    {
        return $user->can('View Kegiatan');
    }

    public function create(User $user): bool
    {
        return $user->can('Create Kegiatan');
    }

    public function update(User $user, Kegiatan $model): bool
    {
        return $user->can('Update Kegiatan');
    }

    public function delete(User $user, Kegiatan $model): bool
    {
        return $user->can('Delete Kegiatan');
    }

    public function restore(User $user, Kegiatan $model): bool
    {
        return $user->can('Restore Kegiatan');
    }

    public function forceDelete(User $user, Kegiatan $model): bool
    {
        return $user->can('Force Delete Kegiatan');
    }
}