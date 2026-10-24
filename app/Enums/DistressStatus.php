<?php

namespace App\Enums;

enum DistressStatus: string
{
    case Open = 'open';
    case Responding = 'responding';
    case Resolved = 'resolved';

    public function label(): string
    {
        return match ($this) {
            self::Open => 'Awaiting response',
            self::Responding => 'Help is responding',
            self::Resolved => 'Resolved',
        };
    }
}
