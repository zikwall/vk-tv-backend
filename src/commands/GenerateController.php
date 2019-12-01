<?php

namespace zikwall\vktv\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Html;
use zikwall\m3uparse\Aggregation;

use zikwall\m3uparse\parsers\{
    free\Free,
    freebesttv\FreeBestTv,
    vasiliy78L\Base
};

use vktv\models\Playlist;

class GenerateController extends Controller
{
    public $message;

    public function options($actionID)
    {
        return ['message'];
    }

    public function optionAliases()
    {
        return ['m' => 'message'];
    }

    public function actionIndex()
    {
        $agg = new Aggregation(new \zikwall\m3uparse\Configuration());
        $playlist = $agg->merge(new Base(), new FreeBestTv());

        if (empty($playlist)) {
            return;
        }

        Playlist::deleteAll();

        Yii::$app->db->createCommand()->batchInsert('{{playlist}}',
            ['epg_id', Html::encode('name'), 'url', 'ssl'],
            $playlist
        )->execute();
    }
}
