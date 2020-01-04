<?php

namespace zikwall\vktv\controllers;

use Yii;
use yii\db\Query;
use yii\web\Response;

class ApiController extends BaseController
{
    public function actionChannels(int $useHttp = 0)
    {
        /**
         * TODO Create Cache Layer
         *
         * Caches:
         * - http/https
         * - https
         */
        $playlists = (new Query())
            ->select(['epg_id', 'name', 'url', 'image', 'use_origin'])
            ->from('playlist')
            ->where(['and',
                [
                    'active' => 1
                ],
                [
                    'blocked' => 0,
                ]
            ]);

        if ($useHttp === 0) {
            $playlists->andWhere(['ssl' => 1]);
        }

        return $this->asJson($playlists->all());
    }

    public function actionBlockedList()
    {
        //
    }

    public function actionInactiveList()
    {
        //
    }

    public function actionFaq()
    {
        $faq = (new Query())
            ->select(['question', 'answer'])
            ->from('{{%faq}}')
            ->where(['visible' => 1])
            ->orderBy('order');

        return $this->asJson($faq->all());
    }
}
