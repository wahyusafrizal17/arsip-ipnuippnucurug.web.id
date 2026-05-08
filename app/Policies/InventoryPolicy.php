<?php

namespace App\Policies;

use App\Models\Inventory;
use App\Models\User;
use App\Support\OrganizationAccess;

class InventoryPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Inventory $inventory): bool
    {
        return OrganizationAccess::inventoryVisibleToNonAdmin($user, $inventory->organization);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Inventory $inventory): bool
    {
        return $this->view($user, $inventory);
    }

    public function delete(User $user, Inventory $inventory): bool
    {
        return $this->view($user, $inventory);
    }
}
