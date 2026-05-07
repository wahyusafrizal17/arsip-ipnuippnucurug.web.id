<?php

namespace App\Policies;

use App\Models\JointLetter;
use App\Models\User;

class JointLetterPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, JointLetter $jointLetter): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, JointLetter $jointLetter): bool
    {
        return true;
    }

    public function delete(User $user, JointLetter $jointLetter): bool
    {
        return true;
    }
}
