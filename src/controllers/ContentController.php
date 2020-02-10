<?php

namespace zikwall\vktv\controllers;

use vktv\helpers\Category;
use vktv\helpers\ContentContainer;
use vktv\helpers\SimpleValidator;
use vktv\helpers\Type;
use vktv\models\Playlist;
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
    public function actionCreate()
    {
        if ($this->isRequestOptions()) {
            return true;
        }

        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED, 200);
        }

        if ($this->isRequestPost() === false) {
            return $this->response([
                'code' => 100,
                'response' => 'Не правильно сформированный HTTP запрос.'
            ]);
        }

        $contentAttributes = $this->getJSONBody();
        $user = $this->getUser();
        $saveToPlaylist = false;

        $validate = SimpleValidator::validateContentForm($contentAttributes);

        if ($validate['code'] === 100) {
            return $this->response($validate);
        }

        if ($contentAttributes['in_main']) {
            if ($user->is_official !== 1) {
                return $this->response([
                    'code' => 100,
                    'message' => 'Вы не являетесь оффициальным представителем и не можете добавлять контент на главную страницу!',
                    'attributes' => [
                        'in_main'
                    ]
                ], 200);
            }

            $saveToPlaylist = true;
        }

        $content = ContentContainer::saveWithActiveRecord(new \vktv\models\Content(), $contentAttributes, $user);

        if ($content !== false) {
            $withPlaylist = false;

            if ($saveToPlaylist && ContentContainer::savePlaylistAfterContent(new Playlist(), $content, $user) !== false) {
                $withPlaylist = true;
            }

            return $this->response([
                'code' => 200,
                'response' => sprintf('Все нормально в скором времени Вы сможете увидеть свой контент!%s',
                    $withPlaylist ? ' И на главной тоже!' : '')
            ]);
        }

        return $this->response([
            'code' => 100,
            'response' => 'Не удалось создать контент, внутрення ошибка сервера...'
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

    public function actionEdit(int $id)
    {
        if ($this->isRequestOptions()) {
            return true;
        }

        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED, 200);
        }

        $user = $this->getUser();

        $content = \vktv\models\Content::find()
            ->select('{{%content}}.*')
            ->from('{{%content}}')
            ->leftJoin('{{%user}}', '{{%content}}.user_id={{%user}}.id')
            ->where(['{{%content}}.id' => $id])
            ->andWhere(['{{%user}}.id' => $user->getId()])
            ->one();

        if (!$content) {
            return $this->response([
                'code' => 100,
                'response' => 'К сожалению данный контент не найден или у Вас нет доступа...'
            ]);
        }

        $playlist = Playlist::find()
            ->where(['and', ['user_id' => $user->getId(), 'content_id' => $content->id]])
            ->one();

        if ($this->isRequestPost()) {
            $updateToPlaylist = false;
            $contentAttributes = $this->getJSONBody();

            $validate = SimpleValidator::validateContentForm($contentAttributes);

            if ($validate['code'] === 100) {
                return $this->response($validate);
            }

            if ($contentAttributes['in_main'] && $user->is_official === 1) {
                $updateToPlaylist = true;
            }

            if (ContentContainer::saveWithActiveRecord($content, $contentAttributes, $user) !== false) {
                $withPlaylist = false;

                if ($updateToPlaylist && ContentContainer::savePlaylistAfterContent($playlist, $content, $user) !== false) {
                    $withPlaylist = true;
                }

                return $this->response([
                    'code' => 200,
                    'response' => sprintf('Все нормально Вы успешно обновили данные!%s',
                        $withPlaylist ? ' И на главной тоже!' : '')
                ]);
            }

            return $this->response([
                'code' => 100,
                'response' => 'Что-то пошло не так.. Не удалось обновить контент...'
            ]);
        }

        return $this->response([
            'code' => 200,
            'response' => $content
        ]);
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
