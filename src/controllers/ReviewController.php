<?php

namespace zikwall\vktv\controllers;

use yii\db\Query;

class ReviewController extends BaseController
{
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

    }

    public function actionEdit()
    {

    }

    public function actionDelete()
    {

    }
}