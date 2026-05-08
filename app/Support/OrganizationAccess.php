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
            $letterOrgs = array_keys(config('archive.letter_organizations', []));
            if (in_array($org, $letterOrgs, true)) {
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
            $letterOrgs = array_keys(config('archive.letter_organizations', []));
            if (in_array($org, $letterOrgs, true)) {
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
            $keys = array_keys(config('archive.letter_organizations', []));

            return in_array($fromRequest, $keys, true) ? $fromRequest : 'ipnu';
        }

        return $user->role->letterOrganization() ?? 'ipnu';
    }

    public static function userCanAccessLetterOrganization(User $user, string $letterOrganization): bool
    {
        if ($user->role === UserRole::Admin) {
            return true;
        }

        $org = $user->role->letterOrganization();
        if ($org === null) {
            return false;
        }

        return $letterOrganization === $org;
    }
}
