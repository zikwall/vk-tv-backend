<?php

namespace zikwall\vktv;

use Yii;

class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();

        if (Yii::$app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'zikwall\vktv\commands';
        }
    }
}