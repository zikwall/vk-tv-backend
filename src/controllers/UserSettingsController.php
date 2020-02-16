<?php


namespace zikwall\vktv\controllers;

use zikwall\vktv\constants\Auth;

class UserSettingsController extends BaseController
{
    public function beforeAction($action): bool
    {
        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED, 401);
        }
    }
}
