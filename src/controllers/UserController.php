<?php

namespace zikwall\vktv\controllers;

use vktv\helpers\Category;
use Yii;
use yii\db\Expression;
use yii\db\Query;
use zikwall\vktv\constants\Content;
use zikwall\vktv\RequestTrait;

class UserController extends BaseController
{
    use RequestTrait;

    public function actionList()
    {
        $users = (new Query())
            ->select([
                '{{%user}}.id', '{{%user}}.username', '{{%user}}.is_premium', '{{%user}}.created_at',
                '{{%user}}.is_official', '{{%profile}}.name', '{{%profile}}.avatar', '{{%profile}}.public_email'
            ])
            ->from('{{%user}}')
            ->leftJoin('{{%profile}}', '{{%profile}}.user_id={{%user}}.id')
            ->where(['and',
                [
                    '{{%user}}.is_destroy' => 0
                ],
                [
                    'is', '{{%user}}.blocked_at', new Expression('NULL')
                ]
            ])->all();

        return $this->response([
            'code' => 200,
            'response' => $users
        ]);
    }

    public function actionProfile(int $userId)
    {
        $user = (new Query())
            ->select([
                '{{%user}}.id', '{{%user}}.username', '{{%user}}.is_premium', '{{%user}}.created_at',
                '{{%user}}.is_official', '{{%profile}}.name', '{{%profile}}.avatar', '{{%profile}}.public_email'
            ])
            ->from('{{%user}}')
            ->leftJoin('{{%profile}}', '{{%profile}}.user_id={{%user}}.id')
            ->where(['and',
                [
                    '{{%user}}.id' => $userId
                ],
                [
                    '{{%user}}.is_destroy' => 0
                ],
                [
                    'is', '{{%user}}.blocked_at', new Expression('NULL')
                ]
            ])->one();

        if (!$user) {
            return $this->response([
                'code' => 404,
                'response' => 'Пользователь не найден :('
            ]);
        }

        return $this->response([
            'code' => 200,
            'response' => $user
        ]);
    }

    public function actionContent(int $userId)
    {
        if (Yii::$app->request->getIsOptions()) {
            return true;
        }

        $isOwner = false;

        if ($this->isUnauthtorized() === false) {
            $isOwner = $userId === $this->getUser()->getId();
        }

        $content = (new Query())
            ->select('*')
            ->from('{{%content}}')
            ->where(['user_id' => $userId])
            ->andWhere(['and',
                [
                    'active' => 1
                ],
                [
                    'blocked' => 0,
                ],
            ]);

        if ($isOwner === false) {
            $content->andWhere([
                '!=', 'visibility', Content::VISIBILITY_PRIVATE
            ]);
        }

        $sinitizeItems = [];
        foreach ($content->all() as $each) {
            $sinitizeItems[] =
                [
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
                    'use_origin'        => (int) $each['use_origin'],
                    'default_player'    => $each['default_player'],
                    'in_main'           => (int) $each['in_main'],
                    'use_own_player_url' => (int) $each['use_own_player_url'],
                    'own_player_url'    => $each['own_player_url']
                ];
        }

        return $this->response([
            'code' => 200,
            'response' => $sinitizeItems
        ]);
    }

    public function actionIWant()
    {
        if (Yii::$app->request->getIsOptions()) {
            return true;
        }

        $attributes = $this->getJSONBody();

        return $this->response([
            'code' => 200,
            'message' => '',
            '__attributes' => $attributes
        ]);
    }
}
