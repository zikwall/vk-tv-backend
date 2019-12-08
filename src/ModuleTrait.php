<?php

namespace zikwall\vktv;

trait ModuleTrait
{
    /**
     * @return Module
     */
    public function getModule()
    {
        return \Yii::$app->getModule('vktv');
    }
}
