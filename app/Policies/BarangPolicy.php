<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Barang;
use Illuminate\Auth\Access\Response;

class BarangPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('View Any Barang');
    }

    public function view(User $user, Barang $model): bool
    {
        return $user->can('View Barang');
    }

    public function create(User $user): bool
    {
        return $user->can('Create Barang');
    }

    public function update(User $user, Barang $model): bool
    {
        return $user->can('Update Barang');
    }

    public function delete(User $user, Barang $model): bool
    {
        return $user->can('Delete Barang');
    }

    public function restore(User $user, Barang $model): bool
    {
        return $user->can('Restore Barang');
    }

    public function forceDelete(User $user, Barang $model): bool
    {
        return $user->can('Force Delete Barang');
    }
}