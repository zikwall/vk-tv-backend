<?php

namespace vktv\helpers;

class Type
{
    const MOVIE = 10;
    const CHANNEL = 20;

    public static function getList() : array
    {
        return [
            self::MOVIE     => 'Фильм',
            self::CHANNEL   => 'Телеканал',
        ];
    }
}
