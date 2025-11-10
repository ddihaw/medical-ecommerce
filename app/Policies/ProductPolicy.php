<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Otorisasi untuk CUD (Create, Update, Delete)
     * Kita cek apakah 'store' milik user sama dengan 'store_id' di produk.
     */
    private function userOwnsProduct(User $user, Product $product): bool
    {
        // Pastikan user adalah seller dan punya toko
        if (! $user->isSeller() || ! $user->store) {
            return false;
        }

        // Cek apakah ID toko user SAMA DENGAN ID toko di produk
        return $user->store->id === $product->store_id;
    }

    /**
     * Otorisasi untuk meng-update produk.
     */
    public function update(User $user, Product $product): bool
    {
        return $this->userOwnsProduct($user, $product);
    }

    /**
     * Otorisasi untuk menghapus produk.
     */
    public function delete(User $user, Product $product): bool
    {
        return $this->userOwnsProduct($user, $product);
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isSeller() && $user->store;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return false;
    }
}
