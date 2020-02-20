<?php

namespace zikwall\vktv\commands;

use vktv\models\Content;
use yii\console\Controller;
use yii\db\Query;
use yii\helpers\Json;

class RecountRatingController extends Controller
{
    public function actionCalculate()
    {
        $query = (new Query())
            ->select('count({{%review}}.id) as cn, sum({{%review}}.value) as sm, {{%review}}.content_id, {{%review}}.value')
            ->from('{{%review}}')
            ->leftJoin('{{%content}}', '{{%content}}.id={{%review}}.content_id')
            ->where(['and',
                [
                    '{{%content}}.active' => 1
                ],
                [
                    '{{%content}}.blocked' => 0,
                ]
            ])
        ->groupBy('{{%review}}.content_id, {{%review}}.value');

        $contentGroups = [];
        
        foreach ($query->all() as $each) {
            $id             = $each['content_id'];
            $group          = $each['value'];
            $countByGroup   = $each['cn'];
            $sumByGroup     = $each['sm'];

            if (!isset($contentGroups[$id])) {
                // First initialize
                $contentGroups[$id] = [
                    'totalCount' => 0,
                    'totalSum' => 0,
                    'rating' => 0,
                    'ratingGroups' => [
                        '5' => 0,
                        '4' => 0,
                        '3' => 0,
                        '2' => 0,
                        '1' => 0
                    ]
                ];
            }

            $contentGroups[$id]['ratingGroups'][$group] = $countByGroup;
            $contentGroups[$id]['totalSum'] += $sumByGroup;
            $contentGroups[$id]['totalCount'] += $countByGroup;
        }

        foreach ($contentGroups as $groupId => $contentGroup) {
            /**
             * @var $contentObj Content
             */
            $contentObj = Content::find()->where(['id' => $groupId])->one();

            if (!$contentObj) {
                echo 'Content not found! ' , $groupId, PHP_EOL;
                continue;
            }
            
            $rating = $contentGroup['totalSum'] / $contentGroup['totalCount'];
            $contentObj->votes = $contentGroup['totalCount'];
            $contentObj->rating = $rating;
            $contentObj->rating_groups = Json::encode($contentGroup['ratingGroups']);
            
            if (!$contentObj->save()) {
                print_r($contentObj->getErrors());
            }
        }
        
        return true;
    }
}