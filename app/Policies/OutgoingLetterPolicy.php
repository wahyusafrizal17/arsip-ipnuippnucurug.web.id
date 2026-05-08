<?php

namespace App\Policies;

use App\Models\OutgoingLetter;
use App\Models\User;
use App\Support\OrganizationAccess;

class OutgoingLetterPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, OutgoingLetter $outgoingLetter): bool
    {
        return OrganizationAccess::letterVisibleToNonAdmin($user, $outgoingLetter->organization, $outgoingLetter->klasifikasi);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, OutgoingLetter $outgoingLetter): bool
    {
        return $this->view($user, $outgoingLetter);
    }

    public function delete(User $user, OutgoingLetter $outgoingLetter): bool
    {
        return $this->view($user, $outgoingLetter);
    }
}
