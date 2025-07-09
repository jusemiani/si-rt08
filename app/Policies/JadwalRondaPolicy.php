<?php

namespace App\Policies;

use App\Models\User;
use App\Models\JadwalRonda;
use Illuminate\Auth\Access\Response;

class JadwalRondaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('View Any JadwalRonda');
    }

    public function view(User $user, JadwalRonda $model): bool
    {
        return $user->can('View JadwalRonda');
    }

    public function create(User $user): bool
    {
        return $user->can('Create JadwalRonda');
    }

    public function update(User $user, JadwalRonda $model): bool
    {
        return $user->can('Update JadwalRonda');
    }

    public function delete(User $user, JadwalRonda $model): bool
    {
        return $user->can('Delete JadwalRonda');
    }

    public function restore(User $user, JadwalRonda $model): bool
    {
        return $user->can('Restore JadwalRonda');
    }

    public function forceDelete(User $user, JadwalRonda $model): bool
    {
        return $user->can('Force Delete JadwalRonda');
    }
}
