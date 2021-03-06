<?php

namespace zikwall\vktv;

use vktv\models\User;
use Yii;
use zikwall\vktv\models\Token;

class Mailer
{
    use ModuleTrait;

    public $viewPath = '@vktv/views/mail';
    public $sender = ['no-reply.playhub@zikwall.ru' => 'PlayHub'];
    public $mailerComponent;
    protected $welcomeSubject;
    protected $newPasswordSubject;
    protected $confirmationSubject;
    protected $reconfirmationSubject;
    protected $recoverySubject;

    public function getWelcomeSubject()
    {
        if ($this->welcomeSubject == null) {
            $this->setWelcomeSubject('Welcome to PlayHub!');
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
            $this->setNewPasswordSubject('Your password on PlayHub has been changed');
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
            $this->setRecoverySubject('Complete password reset on PlayHub');
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
