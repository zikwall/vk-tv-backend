<?php

namespace zikwall\vktv;

use Yii;

class Module extends \yii\base\Module
{
    /**
     * @var string
     */
    public $uploadsRoot = '@app/web/uploads/';
    /**
     * @var string
     */
    public $playlistUploadPath = '@app/web/uploads/playlists';
    /**
     * @var string
     */
    public $epgUploadPath = '@app/web/uploads/epg';

    public function init()
    {
        parent::init();

        if (Yii::$app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'zikwall\vktv\commands';
        }
    }

    public static function module() : Module
    {
        return Yii::$app->getModule('vktv');
    }
}