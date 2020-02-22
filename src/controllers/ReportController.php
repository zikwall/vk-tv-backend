<?php

namespace zikwall\vktv\controllers;

use vktv\models\Report;
use zikwall\vktv\RequestTrait;

class ReportController extends BaseController
{
    use RequestTrait;

    public function actionSend()
    {
        if ($this->isRequestOptions()) {
            return true;
        }

        $isAuth = false;

        if ($this->isUnauthtorized() === false) {
            $isAuth = true;
        }

        $post = $this->getJSONBody();

        $id                 = $post['id'];
        $cause              = $post['type'];
        $description_cause  = $post['description'];
        $comment            = $post['comment'];

        $reportObj = new Report();
        $reportObj->content_id = $id;
        $reportObj->user_id = !$isAuth ? null : $this->getUser()->getId();
        $reportObj->cause = $cause;
        $reportObj->description_cause = $description_cause;
        $reportObj->comment = strlen($comment) === 0 ? null : $comment;

        if ($reportObj->save()) {
            return $this->response([
                'code' => 200,
                'message' => 'Ваша жалоба принята, в ближайшее время мы его рассмотрим.'
            ]);
        }

        return $this->response([
            'code' => 100,
            'message' => 'Не удалось зарегистрировать жалобу...'
        ]);
    }
}
