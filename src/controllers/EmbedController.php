<?php


namespace zikwall\vktv\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\web\Response;

class EmbedController extends Controller
{
    public $layout = 'embed';

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

    public function actionGive(int $epg)
    {
        if (empty($epg)) {
            return \yii\base\InvalidArgumentException('Epg ID is required');
        }

        $embed = (new Query())
            ->select('url')
            ->from('playlist')
            ->where(['and',
                [
                    'epg_id' => $epg
                ],
                [
                    'blocked' => 0
                ]
            ])
            ->one();

        if (!$embed) {
            return \yii\web\NotFoundHttpException('Channed Not Found');
        }

        return $this->render('give', [
            'embed' => $embed
        ]);
    }
}
