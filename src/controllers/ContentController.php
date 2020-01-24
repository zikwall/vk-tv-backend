<?php

namespace zikwall\vktv\controllers;

use Yii;
use zikwall\vktv\RequestTrait;
use zikwall\vktv\constants\{
    Auth,
    Validation
};
use vktv\helpers\AttributesValidator;

class ContentController extends BaseController
{
    use RequestTrait;

    public function actionCreate()
    {
        if ($this->isRequestOptions()) {
            return true;
        }

        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED, 200);
        }
    }

    public function actionDelete()
    {
        if ($this->isRequestOptions()) {
            return true;
        }

        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED, 200);
        }
    }

    public function actionEdit()
    {
        if ($this->isRequestOptions()) {
            return true;
        }

        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED, 200);
        }
    }

    public function actionReport()
    {
        if ($this->isRequestOptions()) {
            return true;
        }

        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED, 200);
        }
    }
}