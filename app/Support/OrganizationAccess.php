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

        if ($user->role->letterOrganization() !== null) {
            self::applyNonAdminLetterScope($query, $user);
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

        if ($user->role->letterOrganization() !== null) {
            self::applyNonAdminLetterScope($query, $user);
        }
    }

    /**
     * Non-admin: surat organisasi sendiri, plus semua surat klasifikasi "bersama"
     * (mis. disimpan dengan organization ipnu_ippnu oleh admin).
     */
    public static function applyNonAdminLetterScope(Builder $query, User $user): void
    {
        $org = $user->role->letterOrganization();
        if ($org === null) {
            return;
        }

        $allowed = KlasifikasiOptions::keysForUser($user);
        $query->whereIn('klasifikasi', $allowed)
            ->where(function (Builder $q) use ($org) {
                $q->where('organization', $org)
                    ->orWhere('klasifikasi', 'bersama');
            });
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

        if (! in_array($klasifikasi, KlasifikasiOptions::keysForUser($user), true)) {
            return false;
        }

        if ($klasifikasi === 'bersama') {
            return true;
        }

        $org = $user->role->letterOrganization();

        return $org !== null && $organization === $org;
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

        self::applyNonAdminInventoryScope($query, $user);
    }

    /**
     * Inventaris organisasi sendiri + inventaris arsip gabungan (ipnu_ippnu).
     */
    public static function applyNonAdminInventoryScope(Builder $query, User $user): void
    {
        if ($user->role === UserRole::Admin) {
            return;
        }

        $org = $user->role->letterOrganization();
        if ($org === null) {
            return;
        }

        $query->where(function (Builder $q) use ($org) {
            $q->where('organization', $org)
                ->orWhere('organization', 'ipnu_ippnu');
        });
    }

    public static function inventoryVisibleToNonAdmin(User $user, string $organization): bool
    {
        if ($user->role === UserRole::Admin) {
            return true;
        }

        if ($organization === 'ipnu_ippnu') {
            return in_array($user->role, [UserRole::Ipnu, UserRole::Ippnu], true);
        }

        $org = $user->role->letterOrganization();

        return $org !== null && $organization === $org;
    }
}
