<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\OutgoingLetter;
use App\Models\User;

class OutgoingLetterPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, OutgoingLetter $outgoingLetter): bool
    {
        if ($user->role === UserRole::Admin) {
            return true;
        }

        $org = $user->role->letterOrganization();

        return $org !== null && $outgoingLetter->organization === $org;
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
