<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Ipnu = 'ipnu';
    case Ippnu = 'ippnu';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Ipnu => 'IPNU',
            self::Ippnu => 'IPPNU',
        };
    }

    /**
     * Organization key for scoped surat (not applicable for admin).
     */
    public function letterOrganization(): ?string
    {
        return match ($this) {
            self::Admin => null,
            self::Ipnu => 'ipnu',
            self::Ippnu => 'ippnu',
        };
    }
}
