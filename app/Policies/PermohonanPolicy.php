<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Permohonan;
use Illuminate\Auth\Access\Response;

class PermohonanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('View Any Permohonan');
    }

    public function view(User $user, Permohonan $model): bool
    {
        return $user->can('View Permohonan');
    }

    public function create(User $user): bool
    {
        return $user->can('Create Permohonan');
    }

    public function update(User $user, Permohonan $model): bool
    {
        return $user->can('Update Permohonan');
    }

    public function delete(User $user, Permohonan $model): bool
    {
        return $user->can('Delete Permohonan');
    }

    public function restore(User $user, Permohonan $model): bool
    {
        return $user->can('Restore Permohonan');
    }

    public function forceDelete(User $user, Permohonan $model): bool
    {
        return $user->can('Force Delete Permohonan');
    }
}