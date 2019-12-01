<?php

namespace zikwall\vktv\controllers;

use Yii;
use yii\db\Query;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\web\Response;

class ApiController extends Controller
{
    public function beforeAction($action)
    {
        Yii::$app->response->headers->set('Access-Control-Allow-Methods', ['POST', 'OPTIONS']);
        Yii::$app->response->headers->set('Access-Control-Allow-Headers', implode(', ', [
            "Accept", "Origin", "X-Auth-Token", "content-type",
            "Content-Type", "Authorization", "X-Requested-With",
            "Accept-Language", "Last-Event-ID", "Accept-Language",
            "Cookie", "Content-Length", "WWW-Authenticate", "X-XSRF-TOKEN",
            "withcredentials", "x-forwarded-for", "x-real-ip",
            "user-agent", "keep-alive", "host",
            "connection", "upgrade", "dnt", "if-modified-since", "cache-control",
            "x-compress"
        ]));
        Yii::$app->response->headers->set('Access-Control-Allow-Origin', '*');
        Yii::$app->response->headers->set('Access-Control-Allow-Credentials', true);
        Yii::$app->response->headers->set('Access-Control-Max-Age', 86400);

        return true;
    }

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
            ->select(['epg_id', 'name', 'url'])
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
}
