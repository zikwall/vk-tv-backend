<?php

namespace zikwall\vktv;

use Yii;

class Module extends \yii\base\Module
{
    public $enabledForAllUsers = false;
    public $disabledUsers = [];
    public $jwtKey = 'shwjskwskwsluhrnfrlkfeHWJSKuwmswkUWKwnskiwswswlkmdc';
    public $jwtExpire = 1800;
    public $enableBasicAuth = false;

    public $rememberFor = 1209600;
    public $enableConfirmation = false;
    public $enableUnconfirmedLogin = false;

    public function init()
    {
        parent::init();

        if (Yii::$app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'zikwall\vktv\commands';
        }
    }
}
