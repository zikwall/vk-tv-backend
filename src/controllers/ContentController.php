<?php

namespace zikwall\vktv\controllers;

use vktv\helpers\Category;
use vktv\helpers\Type;
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

        /**
         * Example request POST JSON data
         *
         * {
         *      "ad_url": "",
         *      "category": 70,
         *      "desc": "Test desc",
         *      "image_url": "",
         *      "in_main": true,
         *      "is_18_years_old": false,
         *      "is_active": true,
         *      "is_archive": false,
         *      "is_pinned": true,
         *      "name": "Test",
         *      "own_player_url": "",
         *      "type": 10,
         *      "url": "https://iptv-org.github.io/iptv/countries/ru.m3u",
         *      "use_own_player": false
         * }
         */
        $post = $this->getJSONBody();
        $user = $this->getUser();

        if ($post['in_main'] && $user->is_official !== 1) {
            return $this->response([
                'code' => 100,
                'message' => 'Вы не являетесь оффициальным представителем и не можете добавлять контент на главную страницу!',
                'attributes' => [
                    'in_main'
                ]
            ], 200);
        }

        if (strlen($post['name']) <= 0 || strlen($post['name']) > 30) {
            return $this->response([
                'code' => 100,
                'message' => 'Наименование не может быть пустым и длинее 30 символов.',
                'attributes' => [
                    'name'
                ]
            ], 200);
        }

        if (strlen($post['url']) <= 0 || strlen($post['url']) > 250) {
            return $this->response([
                'code' => 100,
                'message' => 'Ссылка на вещание не может быть пустым и длинее 250 символов.',
                'attributes' => [
                    'url'
                ]
            ], 200);
        }

        if (strlen($post['url']) > 0) {
            if (!preg_match('/([a-zA-Z0-9\s_\\.\-\(\):])+(.m3u|.m3u8)$/i', $post['url']) || !AttributesValidator::isValidURL($post['url'])) {
                return $this->response([
                    'code' => 100,
                    'message' => 'Некорректная ссылка на вещание.',
                    'attributes' => [
                        'url'
                    ]
                ], 200);
            }
        }

        if (strlen($post['image_url']) > 0) {

        }

        if (strlen($post['ad_url']) > 0) {

        }

        if ($post['use_own_player'] || strlen($post['own_player_url']) > 0) {

        }

        if (strlen($post['desc']) > 1000) {

        }

        if (!in_array($post['type'], array_keys(Type::getList()))) {

        }

        if (!in_array($post['category'], array_keys(Category::getList()))) {

        }

        return $this->response([
            'code' => 200,
            'response' => 'Все нормально в скором времени Вы сможете увидеть свой контент!'
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
