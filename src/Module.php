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

    /** @var int The time before a confirmation token becomes invalid. */
    public $confirmWithin = 86400; // 24 hours

    /** @var int The time before a recovery token becomes invalid. */
    public $recoverWithin = 21600; // 6 hours

    /**
     * @var Mailer
     */
    public $mailer = null;

    public function init()
    {
        parent::init();

        if (Yii::$app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'zikwall\vktv\commands';
        }

        $this->mailer = new Mailer();
    }

    public function getMailer() : Mailer
    {
        return $this->mailer;
    }
}
