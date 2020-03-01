<?php

namespace zikwall\vktv;

use vktv\models\User;
use Yii;
use zikwall\vktv\models\Token;

class Mailer
{
    use ModuleTrait;

    public $viewPath = '@vktv/views/mail';
    public $sender = ['community.playhub@gmail.com' => 'PlayHub'];
    public $mailerComponent;
    protected $welcomeSubject;
    protected $newPasswordSubject;
    protected $confirmationSubject;
    protected $reconfirmationSubject;
    protected $recoverySubject;

    public function getWelcomeSubject()
    {
        if ($this->welcomeSubject == null) {
            $this->setWelcomeSubject(Yii::t('user', 'Welcome to {0}', Yii::$app->name));
        }

        return $this->welcomeSubject;
    }

    public function setWelcomeSubject($welcomeSubject)
    {
        $this->welcomeSubject = $welcomeSubject;
    }

    public function getNewPasswordSubject()
    {
        if ($this->newPasswordSubject == null) {
            $this->setNewPasswordSubject(Yii::t('user', 'Your password on {0} has been changed', Yii::$app->name));
        }

        return $this->newPasswordSubject;
    }

    public function setNewPasswordSubject($newPasswordSubject)
    {
        $this->newPasswordSubject = $newPasswordSubject;
    }

    public function getRecoverySubject()
    {
        if ($this->recoverySubject == null) {
            $this->setRecoverySubject(Yii::t('user', 'Complete password reset on {0}', Yii::$app->name));
        }

        return $this->recoverySubject;
    }

    public function setRecoverySubject($recoverySubject)
    {
        $this->recoverySubject = $recoverySubject;
    }

    public function sendWelcomeMessage(User $user, $showPassword = false)
    {
        return $this->sendMessage(
            $user->email,
            $this->getWelcomeSubject(),
            'welcome',
            ['user' => $user, 'module' => $this->getModule(), 'showPassword' => $showPassword]
        );
    }

    public function sendRecoveryMessage(User $user, Token $token)
    {
        return $this->sendMessage(
            $user->email,
            $this->getRecoverySubject(),
            'recovery',
            ['user' => $user, 'token' => $token]
        );
    }

    protected function sendMessage($to, $subject, $view, $params = [])
    {
        $mailer = $this->mailerComponent === null ? Yii::$app->mailer : Yii::$app->get($this->mailerComponent);
        $mailer->viewPath = $this->viewPath;
        $mailer->getView()->theme = Yii::$app->view->theme;

        if ($this->sender === null) {
            $this->sender = isset(Yii::$app->params['adminEmail']) ?
                Yii::$app->params['adminEmail']
                : 'no-reply@example.com';
        }

        return $mailer->compose(['html' => $view, 'text' => 'text/' . $view], $params)
            ->setTo($to)
            ->setFrom($this->sender)
            ->setSubject($subject)
            ->send();
    }
}
