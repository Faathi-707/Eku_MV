<?php

namespace App\Enums;

enum CommunityPostType: string
{
    case Hazard = 'hazard';
    case Reroute = 'reroute';
    case Distress = 'distress';

    public function label(): string
    {
        return match ($this) {
            self::Hazard => 'Hazard',
            self::Reroute => 'Rerouting',
            self::Distress => 'Distress / Request Aid',
        };
    }

    /**
     * Distress calls may be sent without a photo, since the sender may not be able to take one.
     */
    public function requiresPhoto(): bool
    {
        return $this !== self::Distress;
    }
}
