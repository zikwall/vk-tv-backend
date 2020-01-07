<?php

namespace vktv\helpers;

class Category
{
    const MOVIE = 10;
    const INFORMATIVE = 20;
    const NEWS = 30;
    const SPORT = 40;
    const CHILDREN = 50;
    const HOBBY = 60;
    const ENTERTAINIG = 70;
    const MUSIC = 80;
    const COMMON = 90;

    public static function getList() : array
    {
        return [
            self::MOVIE         => 'Кино и фильмы',
            self::INFORMATIVE   => 'Позновательные',
            self::NEWS          => 'Новостные',
            self::SPORT         => 'Спортивные',
            self::CHILDREN      => 'Детские',
            self::HOBBY         => 'Хобби',
            self::ENTERTAINIG   => 'Развлекательные',
            self::MUSIC         => 'Музыкальные',
            self::COMMON        => 'Общие'
        ];
    }

    public static function getName(int $categoryId) : string
    {
        if (!in_array($categoryId, array_keys(self::getList()))) {
            $categoryId = self::COMMON;
        }

        return self::getList()[$categoryId];
    }
    
    public static function getDefaultCategory() : int
    {
        return self::COMMON;
    }
}
