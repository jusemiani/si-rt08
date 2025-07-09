<?php

namespace App\Policies;

use App\Models\User;
use App\Models\GaleriKegiatan;
use Illuminate\Auth\Access\Response;

class GaleriKegiatanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('View Any GaleriKegiatan');
    }

    public function view(User $user, GaleriKegiatan $model): bool
    {
        return $user->can('View GaleriKegiatan');
    }

    public function create(User $user): bool
    {
        return $user->can('Create GaleriKegiatan');
    }

    public function update(User $user, GaleriKegiatan $model): bool
    {
        return $user->can('Update GaleriKegiatan');
    }

    public function delete(User $user, GaleriKegiatan $model): bool
    {
        return $user->can('Delete GaleriKegiatan');
    }

    public function restore(User $user, GaleriKegiatan $model): bool
    {
        return $user->can('Restore GaleriKegiatan');
    }

    public function forceDelete(User $user, GaleriKegiatan $model): bool
    {
        return $user->can('Force Delete GaleriKegiatan');
    }
}
