<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Pengeluaran;
use Illuminate\Auth\Access\Response;

class PengeluaranPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('View Any Pengeluaran');
    }

    public function view(User $user, Pengeluaran $model): bool
    {
        return $user->can('View Pengeluaran');
    }

    public function create(User $user): bool
    {
        return $user->can('Create Pengeluaran');
    }

    public function update(User $user, Pengeluaran $model): bool
    {
        return $user->can('Update Pengeluaran');
    }

    public function delete(User $user, Pengeluaran $model): bool
    {
        return $user->can('Delete Pengeluaran');
    }

    public function restore(User $user, Pengeluaran $model): bool
    {
        return $user->can('Restore Pengeluaran');
    }

    public function forceDelete(User $user, Pengeluaran $model): bool
    {
        return $user->can('Force Delete Pengeluaran');
    }
}