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
    public $enableGeneratingPassword = false;
    public $enableUnconfirmedLogin = false;

    // user
    public $cost = 10;

    public function init()
    {
        parent::init();

        if (Yii::$app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'zikwall\vktv\commands';
        }
    }
}
