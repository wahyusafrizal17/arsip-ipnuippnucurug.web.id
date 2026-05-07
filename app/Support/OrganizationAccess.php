<?php

namespace App\Support;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class OrganizationAccess
{
    public static function scopeIncomingForUser(Builder $query, Request $request): void
    {
        $user = $request->user();
        if (! $user instanceof User) {
            return;
        }

        if ($user->role === UserRole::Admin) {
            $org = $request->query('organization');
            if ($org === 'ipnu' || $org === 'ippnu') {
                $query->where('organization', $org);
            }

            return;
        }

        $org = $user->role->letterOrganization();
        if ($org !== null) {
            $query->where('organization', $org);
        }
    }

    public static function scopeOutgoingForUser(Builder $query, Request $request): void
    {
        $user = $request->user();
        if (! $user instanceof User) {
            return;
        }

        if ($user->role === UserRole::Admin) {
            $org = $request->query('organization');
            if ($org === 'ipnu' || $org === 'ippnu') {
                $query->where('organization', $org);
            }

            return;
        }

        $org = $user->role->letterOrganization();
        if ($org !== null) {
            $query->where('organization', $org);
        }
    }

    public static function resolveLetterOrganizationForUser(User $user, ?string $fromRequest): string
    {
        if ($user->role === UserRole::Admin) {
            return in_array($fromRequest, ['ipnu', 'ippnu'], true) ? $fromRequest : 'ipnu';
        }

        return $user->role->letterOrganization() ?? 'ipnu';
    }
}
