<?php

namespace App\Constants;


enum SchoolStatus: int
{
    /**
     * Teacher Apply
     */
    case Apply = 0x00;

    /**
     * Admin Approved
     */
    case Approved = 0x01;

    public static function description(int $value): string
    {
        return match (self::from($value)) {
            self::Apply => 'apply',
            self::Approved => 'approved',
        };
    }
}
