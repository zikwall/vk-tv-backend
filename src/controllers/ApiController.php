<?php

namespace zikwall\vktv\controllers;

use Yii;
use yii\db\Query;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\web\Response;

class ApiController extends Controller
{
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    public function actionChannels()
    {
        $playlists = (new Query())
            ->select(['epg_id', 'name', 'url'])
            ->from('playlist')
            ->all();

        return $playlists;
    }
}