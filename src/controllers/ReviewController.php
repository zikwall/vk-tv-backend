<?php

namespace zikwall\vktv\controllers;

use Yii;
use vktv\models\Content;
use vktv\models\Review;
use yii\db\Query;
use zikwall\vktv\constants\Auth;
use zikwall\vktv\RequestTrait;
use vktv\helpers\AttributesValidator;
use zikwall\vktv\constants\Validation;

class ReviewController extends BaseController
{
    use RequestTrait;

    public function actionExist()
    {
        if (Yii::$app->request->getIsOptions()) {
            return true;
        }

        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED, 200);
        }

        if ($this->isRequestPost() === false) {
            return $this->response([
                'code' => 100,
                'response' => 'Не правильно сформированный HTTP запрос.',
                'attributes' => []
            ]);
        }

        $reviewAttributes = $this->getJSONBody();
        $user = $this->getUser();

        $validate = AttributesValidator::isEveryRequired($reviewAttributes, ['id']);
        if ($validate['state'] === false) {
            return $this->response(
                array_merge(Validation::NOT_REQUIRED_ATTRIBUTES, ['attributes' => $validate['missing']
                ])
            );
        }

        $id = $reviewAttributes['id'];
        $exist = Review::find()->where(['content_id' => $id, 'user_id' => $user->getId()])->one();

        return $this->response([
            'code' => 200,
            'response' => [
                'exist' => !!$exist ? 1 : 0,
                'review' => $exist
            ]
        ]);
    }

    public function actionReviews(int $contentId, int $offset = 0, int $paginationSize = 20)
    {
        $query = (new Query())
            ->select('{{%review}}.*, {{%user}}.username, {{%profile}}.name')
            ->from('{{%review}}')
            ->leftJoin('{{%user}}', '{{%user}}.id={{%review}}.user_id')
            ->leftJoin('{{%profile}}', '{{%profile}}.user_id={{%user}}.id')
            ->where(['content_id' => $contentId]);

        if ($this->isUnauthtorized() === false) {
            $userId = $this->getUser()->getId();
            $query->leftJoin('{{%review_useful}}',
                sprintf('`review_useful`.`review_id`=`review`.`id` AND `user`.`id`=%d', $userId)
            );
        }

        $cloneQuery = clone $query;
        $count = $cloneQuery->count();
        $countPages = (int) ceil($count/$paginationSize);

        $response = [];
        $query->offset($offset * $paginationSize)->limit($paginationSize);
        foreach ($query->all() as $item) {
            $response[] = [
                'id'        => $item['id'],
                'content'   => $item['content'],
                'value'     => $item['value'],
                'date'      => date('d.m.Y', $item['created_at']),
                'user'      => [
                    'username'  => $item['username'],
                    'name'      => $item['name']
                ]
            ];
        }

        return $this->response([
            'code'      => 200,
            'response'  => [
                'count_pages'   => $countPages,
                'reviews'       => $response,
                'end'           => $countPages === $offset
            ]
        ]);
    }

    public function actionAdd()
    {
        if (Yii::$app->request->getIsOptions()) {
            return true;
        }

        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED, 200);
        }

        if ($this->isRequestPost() === false) {
            return $this->response([
                'code' => 100,
                'response' => 'Не правильно сформированный HTTP запрос.',
                'attributes' => []
            ]);
        }

        $reviewAttributes = $this->getJSONBody();
        $user = $this->getUser();

        $validate = AttributesValidator::isEveryRequired($reviewAttributes, ['id', 'content', 'value']);

        if ($validate['state'] === false) {
            return $this->response(
                    array_merge(Validation::NOT_REQUIRED_ATTRIBUTES, ['attributes' => $validate['missing']
                ])
            );
        }

        $id         = $reviewAttributes['id'];
        $content    = $reviewAttributes['content'];
        $value      = $reviewAttributes['value'];

        $contentObj = Content::find()->where(['id' => $id])->one();

        if (!$contentObj) {
            return $this->response([
                'code' => 100,
                'message' => 'Контент для отзыва не найден',
                'attributes' => []
            ]);
        }

        $exist = Review::find()->where(['content_id' => $id, 'user_id' => $user->getId()])->one();

        if ($exist) {
            return $this->response([
                'code' => 100,
                'message' => 'Вы уже оставляли отзыв.',
                'attributes' => []
            ]);
        }

        $reviewObj = new Review();
        $reviewObj->content_id = $contentObj->id;
        $reviewObj->user_id = $user->getId();
        $reviewObj->content = $content;
        $reviewObj->value = $value;
        $reviewObj->created_at = time();

        if (!$reviewObj->save()) {
            return $this->response([
                'code' => 100,
                'message' => 'Не удалось оставить отзыв, что-то пошло не так...',
                'attributes' => []
            ]);
        }

        return $this->response([
            'code' => 200,
            'message' => 'Вы успешно оставили отзыв! В скором времени оно появится на сервисе.',
            'attributes' => [],
            'new_review' => [
                'id' => $reviewObj->id,
                'value'     => (int) $reviewObj->value,
                'content'   => $reviewObj->value,
                'date'      => date('d.m.Y', $reviewObj->created_at),
                'usefulCount' => 0,
                'isOwnUseful' => null,
                'user' => [
                    'id'        => $user->getId(),
                    'username'  => $user->username,
                    'name'      => $user->profile->name,
                    'avatar'    => $user->profile->avatar
                ]
            ]
        ]);
    }

    public function actionEdit()
    {
        if (Yii::$app->request->getIsOptions()) {
            return true;
        }

        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED, 200);
        }

        if ($this->isRequestPost() === false) {
            return $this->response([
                'code' => 100,
                'response' => 'Не правильно сформированный HTTP запрос.',
                'attributes' => []
            ]);
        }

        $reviewAttributes = $this->getJSONBody();
        $user = $this->getUser();

        $validate = AttributesValidator::isEveryRequired($reviewAttributes, ['id', 'content_id', 'content', 'value']);

        if ($validate['state'] === false) {
            return $this->response(
                array_merge(Validation::NOT_REQUIRED_ATTRIBUTES, ['attributes' => $validate['missing']
                ])
            );
        }

        $id         = $reviewAttributes['id'];
        $content    = $reviewAttributes['content'];
        $value      = $reviewAttributes['value'];
        $content_id = $reviewAttributes['content_id'];

        $reviewObj = Review::find()->where(['id' => $id, 'user_id' => $user->getId(), 'content_id' => $content_id])->one();

        if (!$reviewObj) {
            return $this->response([
                'code' => 100,
                'message' => 'Не удалось найти отзыв...',
                'attributes' => []
            ]);
        }

        $reviewObj->content = $content;
        $reviewObj->value = $value;

        if (!$reviewObj->save()) {
            return $this->response([
                'code' => 100,
                'message' => 'Не удалось отредактировать отзыв, что-то пошло не так...',
                'attributes' => []
            ]);
        }

        return $this->response([
            'code' => 200,
            'message' => 'Вы успешно отредактировлаи отзыв!',
            'attributes' => [],
            'edit_review' => [
                'id' => $reviewObj->id,
                'value'     => (int) $reviewObj->value,
                'content'   => $reviewObj->value,
                'date'      => date('d.m.Y', $reviewObj->created_at),
                'usefulCount' => 0,
                'isOwnUseful' => null,
                'user' => [
                    'id'        => $user->getId(),
                    'username'  => $user->username,
                    'name'      => $user->profile->name,
                    'avatar'    => $user->profile->avatar
                ]
            ]
        ]);
    }

    public function actionDelete()
    {
        if (Yii::$app->request->getIsOptions()) {
            return true;
        }

        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED, 200);
        }

        if ($this->isRequestPost() === false) {
            return $this->response([
                'code' => 100,
                'response' => 'Не правильно сформированный HTTP запрос.',
                'attributes' => []
            ]);
        }

        $reviewAttributes = $this->getJSONBody();
        $user = $this->getUser();

        $validate = AttributesValidator::isEveryRequired($reviewAttributes, ['id']);

        if ($validate['state'] === false) {
            return $this->response(
                array_merge(Validation::NOT_REQUIRED_ATTRIBUTES, ['attributes' => $validate['missing']
                ])
            );
        }

        $id = $reviewAttributes['id'];
        $reviewObj = Review::find()->where(['id' => $id, 'user_id' => $user->getId()])->one();

        if (!$reviewObj) {
            return $this->response([
                'code' => 100,
                'message' => 'Не удалось найти отзыв...',
                'attributes' => []
            ]);
        }

        if (!$reviewObj->delete()) {
            return $this->response([
                'code' => 100,
                'message' => 'Не удалось удалить, что-то пошло не так...',
                'attributes' => []
            ]);
        }

        return $this->response([
            'code' => 200,
            'message' => 'Отзыв успешно удален',
            'attributes' => []
        ]);
    }
}