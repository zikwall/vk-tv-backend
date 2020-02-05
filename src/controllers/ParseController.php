<?php

namespace zikwall\vktv\controllers;

use zikwall\m3ucontentparser\M3UContentParser;
use zikwall\m3ucontentparser\M3UItem;

class ParseController extends BaseController
{
    const PLAYLISTS = [
        'https://iptvm3u.ru/iptv-hd/',
        'https://iptvm3u.ru/one/',
        'https://raw.githubusercontent.com/vasiliy78L/myIPTV/master/iptv.m3u',
        'http://4pda.ru/pages/go/?u=http%3A%2F%2Ftopplay.do.am%2FFreeBestTV.m3u&e=84875135',
        'https://webhalpme.ru/if.m3u'
    ];

    public function actionRandom()
    {
        return $this->response([
            'code' => 200,
            'response' => self::PLAYLISTS[array_rand(self::PLAYLISTS)]
        ]);
    }

    public function actionItems(string $url)
    {
        $items = [];

        $parser = new M3UContentParser($url);
        $parser->parse();

        foreach ($parser->all() as $item) {
            /**
             * @var $item M3UItem
             */
            $items[] = [
                'name' => $item->getTvgName(),
                'logo' => $item->getTvgLogo(),
                'url'  => $item->getTvgUrl()
            ];
        }

        return $this->response([
            'code' => 200,
            'response' => $items
        ], 200);
    }
}