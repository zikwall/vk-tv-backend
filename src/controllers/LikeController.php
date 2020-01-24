<?php

namespace zikwall\vktv\controllers;

use Yii;
use zikwall\vktv\RequestTrait;
use zikwall\vktv\constants\{
    Auth,
    Validation
};
use vktv\helpers\AttributesValidator;

class LikeController extends BaseController
{
    use RequestTrait;

    public function actionLike()
    {
        if ($this->isRequestOptions()) {
            return true;
        }

        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED, 200);
        }

        $post = $this->getJSONBody();
        $validate = AttributesValidator::isEveryRequired($post, ['username', 'password']);

        if ($validate['state'] === false) {
            return $this->response(
                array_merge(Validation::NOT_REQUIRED_ATTRIBUTES, ['attributes' => $validate['missing']
            ]), 200);
        }

        return $this->response([
            'code' => 200,
            'response' => $post
        ], 200);
    }

    public function actionDislike()
    {
        if ($this->isRequestOptions()) {
            return true;
        }

        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED, 200);
        }

        $post = $this->getJSONBody();

        return $this->response([
            'code' => 200,
            'response' => $post
        ], 200);
    }
}