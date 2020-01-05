<?php

namespace vktv\helpers;

class EPGHelper
{
    const PROVIDER_XMLTV = 10;
    const PROVIDER_EPGXML = 20;

    public static function getProviders()
    {
        return [
            self::PROVIDER_XMLTV => 'xmltv_id',
            self::PROVIDER_EPGXML => 'epgxml_id'
        ];
    }

    public static function resolveEPGProvider(int $provider) : string
    {
        if (!in_array($provider, self::getProviders())) {
            return self::getProviders()[self::PROVIDER_XMLTV];
        }

        return self::getProviders()[$provider];
    }

    public static function createDay(array $epgItem) : array
    {
        return [
            'timestamp' => $epgItem['start'],
            'title'     => Date::relativeDayName($epgItem['start']),
            'data'      => []
        ];
    }

    public static function createProgramm(array $epgItem) : array
    {
        return [
            'time'        => date('h:i', $epgItem['start']),
            'name'        => $epgItem['title'],
            'description' => $epgItem['desc'],
            'is_active'   => $epgItem['start'] < time() && $epgItem['stop'] > time()
        ];
    }
}
