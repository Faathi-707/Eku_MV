<?php

namespace App\Enums;

enum DisruptionCategory: string
{
    case Tss = 'tss';
    case Eez = 'eez';
    case Anchorages = 'anchorages';
    case Regulatory = 'regulatory';

    public function label(): string
    {
        return match ($this) {
            self::Tss => 'Traffic Separation Schemes (TSS)',
            self::Eez => 'Exclusive Economic Zone (EEZ)',
            self::Anchorages => 'Negligent Anchorages and Infrastructure Accidents',
            self::Regulatory => 'Overloading and Safety Regulatory Halts',
        };
    }
}
