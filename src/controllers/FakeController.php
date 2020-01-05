<?php

namespace zikwall\vktv\controllers;

use vktv\helpers\Date;
use Yii;
use vktv\models\Faker;

class FakeController extends BaseController
{
    public function actionEpg(string $currentDay = null)
    {
        // for web
        if (Yii::$app->request->getIsOptions()) {
            return true;
        }

        $today = time();

        $ranges = [
            '-5', '-4', '-3', '-2', '-1',
            '0',
            '+1', '+2', '+3', '+4', '+5'
        ];

        $days = [];

        foreach ($ranges as $range) {
            $computedTimestamp = strtotime("{$range} day", $today);
            $humanDate = Date::relativeDayName($computedTimestamp);

            $days[] = [
                'timestamp' => $computedTimestamp,
                'title' => $humanDate,
                'data' => Faker::fullDayEpg($humanDate)
            ];
        }

        return $this->asJson($days);
    }
}
