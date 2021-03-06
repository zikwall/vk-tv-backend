<?php


namespace vktv\models;


class Faker
{
    public static function fullDayEpg(string $date, int $epgId)
    {
        $epg = [];

        for ($i = 0; $i <= 24; $i++) {
            $hour = sprintf("%02d", $i);

            $epg[] = [
                'time' => $hour . ':00 - ' . $hour . ':59',
                'name' => 'Example TV Program ' . $epgId . $date,
                'description' => 'Non description'
            ];
        };

        return $epg;
    }
}
