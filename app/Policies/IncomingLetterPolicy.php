<?php

namespace App\Policies;

use App\Models\IncomingLetter;
use App\Models\User;
use App\Support\OrganizationAccess;

class IncomingLetterPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, IncomingLetter $incomingLetter): bool
    {
        return OrganizationAccess::letterVisibleToNonAdmin($user, $incomingLetter->organization, $incomingLetter->klasifikasi);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, IncomingLetter $incomingLetter): bool
    {
        return $this->view($user, $incomingLetter);
    }

    public function delete(User $user, IncomingLetter $incomingLetter): bool
    {
        return $this->view($user, $incomingLetter);
    }
}
