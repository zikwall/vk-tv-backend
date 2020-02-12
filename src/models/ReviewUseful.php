<?php

namespace vktv\models;

use Yii;

/**
 * This is the model class for table "review_useful".
 *
 * @property int $id
 * @property int $review_id
 * @property int $user_id
 * @property int $value
 */
class ReviewUseful extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%review_useful}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['review_id', 'user_id', 'value'], 'required'],
            [['review_id', 'user_id', 'value'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'review_id' => 'Review ID',
            'user_id' => 'User ID',
            'value' => 'Value',
        ];
    }
}
