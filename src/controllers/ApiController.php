<?php

namespace zikwall\vktv\controllers;

use vktv\helpers\EPGHelper;
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

    public function actionEpg(int $id, int $provider = 10)
    {
        $providerName = EPGHelper::resolveEPGProvider($provider);

        $epgList = (new Query())
            ->select(['title', 'desc', 'start', 'stop', 'day_begin'])
            ->from('{{%epg}}')
            //->where([$providerName => $id])
            ->where(['epg_id' => $id])
            ->orderBy('day_begin')
            ->all();

        $epgResponse = [];
        $counter = 0;
        $activeIndex = 0;

        foreach ($epgList as $item) {
            $day = date('d-m-Y', $item['day_begin']);

            if (!isset($epgResponse[$day])) {
                $epgResponse[$day] = EPGHelper::createDay($item);

                if ($day == date('d-m-Y')) {
                    $activeIndex = $counter;
                }

                $counter++;
            }

            $epgResponse[$day]['data'][] = EPGHelper::createProgramm($item);
        }

        if (count($epgResponse) === 0) {
            return $this->asJson(['active' => $activeIndex, 'data' => []]);
        }

        return $this->asJson(['active' => $activeIndex, 'data' => array_values($epgResponse)]);
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
