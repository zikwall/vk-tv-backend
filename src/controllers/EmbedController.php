<?php


namespace zikwall\vktv\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\web\Response;

class EmbedController extends Controller
{
    const PLAYER_JW = 1;
    const PLAYER_OPENJS = 2;
    const PLAYER_VIDEOJS = 3;
    const PLAYER_PLYR = 4;

    const PLAYER_VIEW = [
        self::PLAYER_JW => '',
        self::PLAYER_OPENJS => '_openplayer',
    ];

    const PLAYER_LAYOUT = [
        self::PLAYER_JW => '',
        self::PLAYER_OPENJS => '_openplayer'
    ];

    public static function getViewByPlayer($id)
    {
        $viewName = self::PLAYER_VIEW[$id];

        return "give{$viewName}";
    }

    public static function getLayoutByPlayer($id)
    {
        $layoutName = self::PLAYER_LAYOUT[$id];

        return "embed{$layoutName}";
    }

    public function setLayout($name)
    {
        $this->layout = $name;
    }

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

    public function actionGive(int $epg, int $player = self::PLAYER_JW)
    {
        $this->setLayout(self::getLayoutByPlayer($player));

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


        return $this->render(self::getViewByPlayer($player), [
            'embed' => $embed
        ]);
    }
}
