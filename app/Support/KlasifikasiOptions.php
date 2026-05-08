<?php

namespace App\Support;

use App\Enums\UserRole;
use App\Models\User;

final class KlasifikasiOptions
{
    /**
     * @return array<string, string>
     */
    public static function forUser(?User $user): array
    {
        $all = config('archive.klasifikasi', []);

        if ($user === null) {
            return $all;
        }

        if ($user->role === UserRole::Admin) {
            return $all;
        }

        if ($user->role === UserRole::Ipnu) {
            return array_intersect_key($all, array_flip(['ipnu']));
        }

        if ($user->role === UserRole::Ippnu) {
            return array_intersect_key($all, array_flip(['ippnu']));
        }

        return $all;
    }

    /**
     * @return list<string>
     */
    public static function keysForUser(?User $user): array
    {
        return array_keys(self::forUser($user));
    }
}
