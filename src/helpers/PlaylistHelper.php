<?php

namespace vktv\helpers;


class PlaylistHelper
{
    public static function createImage(string $url) : string
    {
        return sprintf('http://tv.zikwall.ru/images/logo/%s.png', $url);
    }

    public static function makeGroup(string $title) : array
    {
        return [
            'title' => $title,
            'data' => []
        ];
    }

    public static function sanitizeItem(array $playlist, bool $useCategory = false) : array
    {
        $pl = [
            'id'            => $playlist['id'],
            'epg_id'        => $playlist['epg_id'],
            'name'          => $playlist['name'],
            'url'           => $playlist['url'],
            'image'         => $playlist['image'],
            'use_origin'    => $playlist['use_origin'],
            'xmltv_id'      => $playlist['xmltv_id'],
        ];

        if ($useCategory) {
            $pl['category'] = Category::getName($playlist['category']);
        }

        return $pl;
    }
}
