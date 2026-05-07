<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\IncomingLetter;
use App\Models\User;

class IncomingLetterPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, IncomingLetter $incomingLetter): bool
    {
        if ($user->role === UserRole::Admin) {
            return true;
        }

        $org = $user->role->letterOrganization();

        return $org !== null && $incomingLetter->organization === $org;
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
