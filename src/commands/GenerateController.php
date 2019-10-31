<?php

namespace zikwall\vktv\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Html;
use zikwall\m3uparse\Aggregation;
use zikwall\m3uparse\Configure;
use zikwall\m3uparse\parsers\{
    Free,
    FreeBestTv
};

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
        $agg = new Aggregation(new Configure('/web/uploads/playlists'));
        $playlist = $agg->merge(new Free(), new FreeBestTv());
        
        Yii::$app->db->createCommand()->batchInsert('{{playlist}}', 
            ['epg_id', Html::encode('name'), 'url'],
            $playlist
        )->execute();
    }
}