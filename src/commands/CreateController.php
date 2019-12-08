<?php

namespace zikwall\vktv\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use vktv\models\User;

class CreateController extends Controller
{
    public function actionUser(string $email, string $username, $password = null)
    {
        $user = Yii::createObject([
            'class'    => User::class,
            'scenario' => 'create',
            'email'    => $email,
            'username' => $username,
            'password' => $password,
        ]);

        if ($user->create()) {
            $this->stdout('User has been created'. "!\n", Console::FG_GREEN);
        } else {
            $this->stdout('Please fix following errors:' . "\n", Console::FG_RED);
            foreach ($user->errors as $errors) {
                foreach ($errors as $error) {
                    $this->stdout(' - ' . $error . "\n", Console::FG_RED);
                }
            }
        }
    }
}
