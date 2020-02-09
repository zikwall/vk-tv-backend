<?php

namespace zikwall\vktv\controllers;

use vktv\helpers\Category;
use Yii;
use yii\db\Query;
use zikwall\vktv\RequestTrait;
use zikwall\vktv\constants\{Auth, Content, Validation};
use vktv\helpers\AttributesValidator;

class ContentController extends BaseController
{
    use RequestTrait;

    public function actionOwn()
    {
        if (Yii::$app->request->getIsOptions()) {
            return true;
        }

        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED, 200);
        }

        $content = (new Query())
            ->select('*')
            ->from('{{%content}}')
            ->where(['user_id' => $this->getUser()->getId()]);

        $response = [];

        foreach ($content->all() as $each) {
            $response[] = [
                'id'                => $each['id'],
                'user_id'           => (int) $each['user_id'],
                'url'               => $each['url'],
                'type'              => (int) $each['type'] === Content::TYPE_CHANNEL ? 'Телеканал' : 'Фильм',
                'category'          => Category::getName($each['category']),
                'name'              => $each['name'],
                'image'             => $each['image'],
                'desc'              => $each['desc'],
                'rating'            => sprintf('%.1f', $each['rating']),
                'age_limit'         => (int) $each['age_limit'],
                'created_at'        => (int) $each['created_at'],
                'updated_at'        => (int) $each['updated_at'],
                'is_auth_required'  => (int) $each['is_auth_required'],
                'visibility'        => (int) $each['visibility'],
                'pinned'            => (int) $each['pinned'],
                'archived'          => (int) $each['archived'],
            ];
        }

        return $this->response([
            'code' => 200,
            'response' => [
                'contents' => $response,
            ]
        ], 200);
    }

    public function actionCreate()
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
        ]);
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
