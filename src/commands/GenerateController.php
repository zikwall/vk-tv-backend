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
use vktv\models\Playlist;
use zikwall\vktv\Module;
use yii\helpers\FileHelper;

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
        if (!is_dir(Yii::getAlias(Module::module()->uploadsRoot))) {
            FileHelper::createDirectory(Yii::getAlias(Module::module()->uploadsRoot), 0777);
        }

        if (!is_dir(Yii::getAlias(Module::module()->playlistUploadPath))) {
            FileHelper::createDirectory(Yii::getAlias(Module::module()->playlistUploadPath), 0777);
        }

        if (!is_dir(Yii::getAlias(Module::module()->epgUploadPath))) {
            FileHelper::createDirectory(Yii::getAlias(Module::module()->epgUploadPath), 0777);
        }

        $agg = new Aggregation(new Configure('/web/uploads/playlists'));
        $playlist = $agg->merge(new Free(), new FreeBestTv());

        if (empty($playlist)) {
            return;
        }

        Playlist::deleteAll();

        Yii::$app->db->createCommand()->batchInsert('{{playlist}}',
            ['epg_id', Html::encode('name'), 'url'],
            $playlist
        )->execute();
    }
}
