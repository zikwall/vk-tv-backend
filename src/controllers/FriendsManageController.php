<?php

namespace zikwall\vktv\controllers;

use vktv\models\Friendship;
use zikwall\vktv\constants\Auth;
use zikwall\vktv\RequestTrait;

class FriendsManageController extends BaseController
{
    use RequestTrait;

    public function actionRequests()
    {
        if ($this->isRequestOptions()) {
            return true;
        }

        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED, 200);
        }

        return $this->response([
            'code' => 200,
            'requests' => Friendship::getReceivedRequestsQuery($this->getUser())->asArray()->all(),
        ], 200);
    }

    public function actionSentRequests()
    {
        if ($this->isRequestOptions()) {
            return true;
        }

        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED, 200);
        }

        return $this->response([
            'code' => 200,
            'requests' => Friendship::getSentRequestsQuery($this->getUser())->asArray()->all(),
        ], 200);
    }
}
