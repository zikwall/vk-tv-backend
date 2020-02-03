<?php

namespace zikwall\vktv\controllers;

use zikwall\m3ucontentparser\M3UContentParser;
use zikwall\m3ucontentparser\M3UItem;

class ParseController extends BaseController
{
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
            'resposne' => $items
        ], 200);
    }
}