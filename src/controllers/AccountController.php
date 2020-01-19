<?php


namespace zikwall\vktv\controllers;

use Yii;
use vktv\models\Profile;
use zikwall\vktv\constants\Auth;
use vktv\helpers\AttributesValidator;

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

        if ($name) {
            $profile->name = $name;
        }

        if ($publiEmail) {
            $profile->public_email = $publiEmail;
        }

        if (!$profile->validate()) {
            return $this->response(array_merge(Auth::ERROR_NOT_VALID_DATA, [
                'attributes' => [
                    'name', 'public_email'
                ],
                'errors' => $profile->getErrors()
            ]), 200);
        }


        // TODO check full equal attributes
        if (!$profile->save()) {
            return $this->response([Auth::ERROR_NOT_SAVED_DATA, 'errors' => $profile->getErrors()], 200);
        }

        if ($this->getUser()->isAlreadyConfirmed() === false) {
            $this->getUser()->confirm();
        }

        return $this->response([
            'code' => 200,
            'response' => [
                'message' => 'Successfully!',
                'user' => [
                    'id' => $this->getUser()->id,
                    'profile' => [
                        'name' => $this->getUser()->profile->name,
                        'public_email' => $this->getUser()->profile->public_email,
                        'avatar' => $this->getUser()->profile->avatar
                    ]
                ]
            ]
        ], 200);
    }

    public function actionChangeSecurity()
    {

    }

    public function actionChangeNotification()
    {

    }
}
