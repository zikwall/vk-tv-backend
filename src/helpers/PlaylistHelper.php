<?php

namespace vktv\helpers;


class PlaylistHelper
{   
    public static function createImage(string $url) : string
    {
        return sprintf('http://tv.zikwall.ru/images/logo/%s.png', $url);
    }
}
