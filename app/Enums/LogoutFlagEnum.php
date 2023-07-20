<?php

declare(strict_types=1);

namespace App\Enums;

enum LogoutFlagEnum: string
{
    case This = 'this';
    case Other = 'other';
    case All = 'all';
    public const VALUES = [
        'this',
        'other',
        'all',
    ];
}