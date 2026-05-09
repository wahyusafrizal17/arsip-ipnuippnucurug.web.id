<?php

namespace App\Support;

final class ArchiveSearch
{
    /**
     * Kunci config (mis. indeks "a") yang label atau key-nya cocok dengan kata kunci pencarian.
     *
     * @return list<string>
     */
    public static function keysMatchingLabelOrKey(string $configKey, string $needle): array
    {
        /** @var array<string, string> $map */
        $map = config($configKey, []);
        if ($map === [] || trim($needle) === '') {
            return [];
        }

        $normalized = mb_strtolower(trim($needle));
        $hits = [];

        foreach ($map as $key => $label) {
            $keyStr = (string) $key;
            $labelStr = (string) $label;
            if (str_contains(mb_strtolower($labelStr), $normalized)
                || str_contains(mb_strtolower($keyStr), $normalized)) {
                $hits[] = $keyStr;
            }
        }

        return array_values(array_unique($hits));
    }
}
