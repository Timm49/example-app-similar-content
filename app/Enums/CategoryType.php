<?php

namespace App\Enums;

enum CategoryType: string
{
    case GENERAL = 'general';
    case POLITICS = 'politics';
    case ECONOMY = 'economy';
    case SPORTS = 'sports';
    case MEDIA_CULTURE = 'media_and_culture';
    case GOSSIP = 'gossip';

    public function label(): string
    {
        return match($this) {
            self::GENERAL => 'General',
            self::POLITICS => 'Politics',
            self::ECONOMY => 'Economy',
            self::SPORTS => 'Sports',
            self::MEDIA_CULTURE => 'Media and Culture',
            self::GOSSIP => 'Gossip',
        };
    }
}
