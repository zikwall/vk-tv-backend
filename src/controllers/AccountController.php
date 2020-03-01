<?php

namespace zikwall\vktv\controllers;

use vktv\models\Friendship;
use vktv\models\User;
use Yii;
use vktv\models\Profile;
use zikwall\vktv\constants\Auth;
use vktv\helpers\AttributesValidator;
use zikwall\vktv\constants\Validation;

class AccountController extends BaseController
{
    public function actionChange()
    {
        if (Yii::$app->request->getIsOptions()) {
            return true;
        }

        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED, 200);
        }

        $post  = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        $name       = $post['name'];
        $publiEmail = $post['publicEmail'];
        $avatar     = $post['avatar'];

        if (!empty($publiEmail)) {
            if (!AttributesValidator::isValidEmail($publiEmail)) {
                return $this->response(Auth::ERROR_INVALID_EMAIL_ADRESS, 200);
            }
        }

        if (!empty($name)) {
            if (!AttributesValidator::isValidRealName($name)) {
                return $this->response(Auth::ERROR_INVALID_NAME, 200);
            }
        }

        /**
         * @var $profile Profile
         */
        $profile = $this->getUser()->profile;

        if (!$profile->validate()) {
            return $this->response(array_merge(Auth::ERROR_NOT_VALID_DATA, [
                'attributes' => [
                    'name', 'public_email'
                ],
                'errors' => $profile->getErrors()
            ]), 200);
        }

        // TODO check full equal attributes
        if (!$profile->updateProfile($name, $publiEmail, $avatar)) {
            return $this->response([Auth::ERROR_NOT_SAVED_DATA, 'errors' => $profile->getErrors()], 200);
        }

        if ($this->getUser()->isAlreadyConfirmed() === false) {
            $this->getUser()->confirm();
        }

        $user = $this->getUser();

        return $this->response([
            'code' => 200,
            'response' => [
                'message' => 'Вы успешно обновили данные!',
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'is_premium' => $user->is_premium && $user->premium_ttl > time(),
                    'is_official' => $user->is_official,
                    'profile' => [
                        'name' => $profile->name,
                        'public_email' => $profile->public_email,
                        'avatar' => $profile->avatar
                    ],
                    'friends' => Friendship::getFriendsQuery($user)->asArray()->all()
                ]
            ]
        ], 200);
    }

    public function actionChangeSecurity()
    {
        if (Yii::$app->request->getIsOptions()) {
            return true;
        }

        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED);
        }

        $post  = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        $validate = AttributesValidator::isEveryRequired($post, ['password', 'password_new', 'password_new_check']);

        if ($validate['state'] === false) {
            return $this->response(
                array_merge(Validation::NOT_REQUIRED_ATTRIBUTES, ['attributes' => $validate['missing']
            ]));
        }

        $old_pass = $post['password'];
        $new_pass = $post['password_new'];
        $new_pass_check = $post['password_new_check'];

        if (!AttributesValidator::isValidPassword($old_pass)) {
            return $this->response([
                'code' => 100,
                'message' => 'Пароль должен содержать не менее восьми символов, как минимум одну заглавную букву, одну строчную букву и одну цифру.',
                'attributes' => [
                    'password'
                ]
            ]);
        }

        if (!AttributesValidator::isValidPassword($new_pass)) {
            return $this->response([
                'code' => 100,
                'message' => 'Пароль должен содержать не менее восьми символов, как минимум одну заглавную букву, одну строчную букву и одну цифру.',
                'attributes' => [
                    'new_password'
                ]
            ]);
        }

        if (!AttributesValidator::isValidPassword($new_pass_check)) {
            return $this->response([
                'code' => 100,
                'message' => 'Пароль должен содержать не менее восьми символов, как минимум одну заглавную букву, одну строчную букву и одну цифру.',
                'attributes' => [
                    'password_new_check'
                ]
            ]);
        }

        if ($new_pass !== $new_pass_check) {
            return $this->response([
                'code' => 100,
                'message' => 'Пароли не совпадают!',
                'attributes' => [
                    'new_password', 'password_new_check'
                ]
            ]);
        }

        $check = AuthController::authByUserAndPassword($this->getUser()->username, $post['password']);

        if ($check instanceof User) {
            $user = $this->getUser();
            $user->password = $new_pass;
            if ($user->save() === false) {
                return $this->response([
                    'code' => 100,
                    'message' => 'Произошла какая-то неведомая ошибка... Не получилось  в обшем поменять пароль.'
                ]);
            }

            return $this->response([
                'code' => 200,
                'message' => 'Вы успешно сменили пароль!'
            ]);
        }

        return $this->response([
            'code' => 100,
            'message' => 'К сожалению процедура смены пароля полность провалилась, крах...'
        ]);
    }

    public function actionChangeNotification()
    {

    }
}
