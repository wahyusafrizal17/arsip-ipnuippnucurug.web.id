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
            $query->where('organization', $org)
                ->whereIn('klasifikasi', KlasifikasiOptions::keysForUser($user));
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
            $query->where('organization', $org)
                ->whereIn('klasifikasi', KlasifikasiOptions::keysForUser($user));
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

    public static function letterVisibleToNonAdmin(User $user, string $organization, string $klasifikasi): bool
    {
        if ($user->role === UserRole::Admin) {
            return true;
        }

        $org = $user->role->letterOrganization();
        if ($org === null || $organization !== $org) {
            return false;
        }

        return in_array($klasifikasi, KlasifikasiOptions::keysForUser($user), true);
    }

    public static function scopeInventoryForUser(Builder $query, Request $request): void
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

    public static function inventoryVisibleToNonAdmin(User $user, string $organization): bool
    {
        if ($user->role === UserRole::Admin) {
            return true;
        }

        $org = $user->role->letterOrganization();

        return $org !== null && $organization === $org;
    }
}
