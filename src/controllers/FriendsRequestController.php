<?php

namespace zikwall\vktv\controllers;

use vktv\helpers\AttributesValidator;
use vktv\models\Friendship;
use vktv\models\User;
use zikwall\vktv\constants\Auth;
use zikwall\vktv\constants\Validation;
use zikwall\vktv\RequestTrait;

class FriendsRequestController extends BaseController
{
    use RequestTrait;

    public function actionList(int $userId)
    {
        if ($this->isRequestOptions()) {
            return true;
        }

        $user = User::find()->where(['id' => $userId])->one();

        if (!$user) {
            return $this->response([
                'code' => 404,
                'response' => 'Пользователь не найден!'
            ]);
        }

        $query = Friendship::getFriendsQuery($user);

        return $this->response([
            'code' => 200,
            'response' => [
                'friends' => $query->asArray()->all()
            ]
        ], 200);
    }

    public function actionAdd()
    {
        if ($this->isRequestOptions()) {
            return true;
        }

        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED, 200);
        }

        $post = $this->getJSONBody();
        $validate = AttributesValidator::isEveryRequired($post, ['user_id']);

        if ($validate['state'] === false) {
            return $this->response(
                array_merge(Validation::NOT_REQUIRED_ATTRIBUTES, ['attributes' => $validate['missing']
                ]), 200);
        }

        $friend = User::findOne(['id' => $post['user_id']]);

        if ($friend === null) {
            return $this->response([
                'code' => 100,
                'message' => 'User not found!'
            ], 200);
        }

        Friendship::add($this->getUser(), $friend);

        return $this->response([
            'code' => 200,
            'message' => 'Successfully added to frineds'
        ], 200);
    }

    public function actionDelete()
    {
        if ($this->isRequestOptions()) {
            return true;
        }

        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED, 200);
        }

        $post = $this->getJSONBody();
        $validate = AttributesValidator::isEveryRequired($post, ['user_id']);

        if ($validate['state'] === false) {
            return $this->response(
                array_merge(Validation::NOT_REQUIRED_ATTRIBUTES, ['attributes' => $validate['missing']
                ]), 200);
        }

        $friend = User::findOne(['id' => $post['user_id']]);

        if ($friend === null) {
            return $this->response([
                'code' => 100,
                'message' => 'User not found!'
            ], 200);
        }

        Friendship::cancel($this->getUser(), $friend);

        return $this->response([
            'code' => 200,
            'message' => 'Successfully canceled request'
        ], 200);
    }
}
