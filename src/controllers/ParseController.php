<?php

namespace zikwall\vktv\controllers;

use zikwall\m3ucontentparser\M3UContentParser;
use zikwall\m3ucontentparser\M3UItem;

class ParseController extends BaseController
{
    const PLAYLISTS = [
        'https://iptvm3u.ru/hdlist.m3u',
        'http://iptvm3u.ru/onelist.m3u',
        //'https://raw.githubusercontent.com/vasiliy78L/myIPTV/master/iptv.m3u',
        'http://4pda.ru/pages/go/?u=http%3A%2F%2Ftopplay.do.am%2FFreeBestTV.m3u&e=84875135',
        'https://iptvm3u.ru/list.m3u',
        'https://iptvm3u.ru/list18.m3u',
        'https://iptvm3u.ru/listru.m3u',
        'https://iptv-org.github.io/iptv/countries/ru.m3u',
        'https://iptvmaster.ru/kids-all.m3u'
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
                'name'      => trim($item->getTvgName()),
                'image'     => $item->getTvgLogo(),
                'url'       => $item->getTvgUrl(),
                'category'  => $item->getGroupTitle()
            ];
        }

        return $this->response([
            'code' => 200,
            'response' => $items
        ], 200);
    }
}
