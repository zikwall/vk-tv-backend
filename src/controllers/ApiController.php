<?php

namespace zikwall\vktv\controllers;

use vktv\helpers\Category;
use vktv\helpers\Date;
use vktv\helpers\EPGHelper;
use vktv\helpers\PlaylistHelper;
use Yii;
use yii\db\Query;
use yii\helpers\Json;
use yii\web\Response;
use zikwall\vktv\constants\Content;

class ApiController extends BaseController
{
    public function actionBest()
    {
        $query = "
              SELECT *
              FROM (
                    SELECT *,
                    /*если в предыдущей строке категория была та же, нумеруем строки внутри категории*/
                    /*иначе присваеваем счетчику 1 (т.е. начинаем нумерацию новой категории)*/
                          IF(@last_category_id=category, @I:=@I+1, @I:=1)N,
                    /*присваеваем ид категории в переменную*/
                          @last_category_id := category
                    FROM content,
                    /*инициализируем локальные переменные*/
                        (SELECT @last_category_id := null, @I := 0)T
                    WHERE active=1 AND blocked=0 AND visibility!=20
                    /*сортируем по категории, затем рейтингу по убыванию*/
                    ORDER BY category, rating, votes ASC
              )T
              /*выводим по 10 строк из каждой секции*/
              WHERE N <= 20
        ";

        $result = Yii::$app->db->createCommand($query)->queryAll();

        $sinitizeItems = [];
        $groupedCounter = [];
        foreach ($result as $each) {
            $categoryId = (int) $each['category'] !== 0 ? $each['category'] : Category::getDefaultCategory();

            if (!isset($sinitizeItems[$categoryId]['name'])) {
                // it is first iteration
                $sinitizeItems[$categoryId]['name'] = Category::getName($categoryId);
                $sinitizeItems[$categoryId]['count'] = 0;
                $sinitizeItems[$categoryId]['items'] = [];
            }

            $sinitizeItems[$categoryId]['count'] = $sinitizeItems[$categoryId]['count'] + 1;
            $sinitizeItems[$categoryId]['items'][] =
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
                    'votes'             => (int) $each['votes'],
                    'rating_groups'     => Json::decode($each['rating_groups']),
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
                    'own_player_url'    => $each['own_player_url'],
                    'tags'              => Json::decode($each['tags']),
                    // extra props
                    'ad_exist'          => (int) !empty($each['ad_url']),
                    // возможно это немного не правильно
                    'native_available'  => (int) (empty($each['ad_url']) && (int) $each['use_origin'] === 1)
                ];
        }

        return $this->response([
            'code' => 200,
            'response' => $sinitizeItems
        ]);
    }

    public function actionContent(int $offset = 0, int $paginationSize = 20)
    {
        $isAuth = false;

        if ($this->isUnauthtorized() === false) {
            $isAuth = true;
        }

        $query = (new Query())->select('*')
            ->from('{{%content}}')
            ->where(['and',
                [
                    'active' => 1
                ],
                [
                    'blocked' => 0,
                ]
            ]);

        if ($isAuth === false) {
            $query->andWhere(['!=', 'visibility', Content::VISIBILITY_PRIVATE]);
        }

        /**
         * TODO parent control
         */
        $cloneQuery = clone $query;
        $count = $cloneQuery->count();
        $countPages = (int) ceil($count/$paginationSize);

        $sinitizeItems = [];
        $query->offset($offset * $paginationSize)->limit($paginationSize);
        foreach ($query->all() as $each) {
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
                    'votes'             => (int) $each['votes'],
                    'rating_groups'     => Json::decode($each['rating_groups']),
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
                    'own_player_url'    => $each['own_player_url'],
                    'tags'              => Json::decode($each['tags']),
                    // extra props
                    'ad_exist'          => (int) !empty($each['ad_url']),
                    // возможно это немного не правильно
                    'native_available'  => (int) (empty($each['ad_url']) && (int) $each['use_origin'] === 1)
                ];
        }

        return $this->response([
            'code' => 200,
            'response' => [
                'count_pages' => $countPages,
                'contents' => $sinitizeItems,
                'end' => $countPages === $offset
            ]
        ], 200);
    }

    public function actionChannels(int $useHttp = 0, int $withGrouped = 1, int $byKeys = 0)
    {
        /**
         * TODO Create Cache Layer
         *
         * Caches:
         * - http/https
         * - https
         */
        $playlists = (new Query())
            ->select(['id', 'epg_id', 'name', 'url', 'image', 'use_origin', 'xmltv_id', 'category'])
            ->from('playlist')
            ->where(['and',
                [
                    'active' => 1
                ],
                [
                    'blocked' => 0,
                ]
            ]);

        if ($useHttp === 0) {
            $playlists->andWhere(['ssl' => 1]);
        }

        if ($withGrouped === 0) {
            $response = [];

            foreach ($playlists->all() as $playlist) {
                if ($byKeys === 1) {
                    $response[$playlist['id']] = PlaylistHelper::sanitizeItem($playlist, true);
                } else {
                    $response[] = PlaylistHelper::sanitizeItem($playlist, true);
                }
            }

            return $this->asJson($response);
        }

        $groupedResponse = [];

        foreach (Category::getList() as $id => $category) {
            $groupedResponse[$id] = PlaylistHelper::makeGroup($category);
        }

        foreach ($playlists->all() as $playlist) {
            $groupedResponse[(int) $playlist['category']]['data'][] = PlaylistHelper::sanitizeItem($playlist);
        }

        return $this->asJson(array_values($groupedResponse));
    }

    public function actionBlockedList()
    {
        //
    }

    public function actionInactiveList()
    {
        //
    }

    public function actionEpgDescription(int $id)
    {
        $currentTime = Date::fix900seconds(time());

        $epg = (new Query())
            ->select(['desc', 'title', 'start', 'stop'])
            ->from('{{%epg}}')
            ->where(['>=', 'day_begin', mktime(0, 0, 0)])
            ->andWhere(['epg_id' => $id])
            ->andWhere([
                'and',
                ['<=', 'start', $currentTime],
                ['>=', 'stop', $currentTime]
            ])
            ->orderBy('day_begin')
            ->one();

        if (!$epg) {
            return $this->asJson([
                'status' => 100,
                'data' => []
            ]);
        }

        return $this->asJson([
            'status' => 200,
            'data' => EPGHelper::createProgramm($epg)
        ]);
    }

    public function actionEpg(int $id, int $provider = 10)
    {
        $providerName = EPGHelper::resolveEPGProvider($provider);

        $epgList = (new Query())
            ->select(['title', 'start', 'stop', 'day_begin'])
            ->from('{{%epg}}')
            //->where([$providerName => $id])
            ->where(['<=', 'day_begin', strtotime('+3 day')])
            ->andWhere(['epg_id' => $id])
            ->orderBy('day_begin')
            ->all();

        $epgResponse = [];
        $counter = 0;
        $activeIndex = 0;

        foreach ($epgList as $item) {
            $day = date('d-m-Y', $item['day_begin']);

            if (!isset($epgResponse[$day])) {
                $epgResponse[$day] = EPGHelper::createDay($item);

                if ($day == date('d-m-Y')) {
                    $activeIndex = $counter;
                }

                $counter++;
            }

            $epgResponse[$day]['data'][] = EPGHelper::createProgramm($item);
        }

        if (count($epgResponse) === 0) {
            return $this->asJson(['active' => $activeIndex, 'data' => []]);
        }

        return $this->asJson(['active' => $activeIndex, 'data' => array_values($epgResponse)]);
    }

    public function actionFaq()
    {
        $faq = (new Query())
            ->select(['question', 'answer'])
            ->from('{{%faq}}')
            ->where(['visible' => 1])
            ->orderBy('order');

        return $this->asJson($faq->all());
    }
}
