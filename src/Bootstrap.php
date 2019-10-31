<?php

namespace zikwall\vktv;

use Yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        Yii::setAlias('@vktv', __DIR__);
    }
}
