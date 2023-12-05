<?php

namespace App\Enums;

enum InventoryStatus: int
{
    case TERSEDIA = 0;
    case DIPINJAM = 1;

    public function label(): string
    {
        return match ($this) {
            self::TERSEDIA => __('Tersedia'),
            self::DIPINJAM => __('Dipinjam')
        };
    }
}
