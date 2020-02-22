<?php

namespace vktv\models;

use Yii;

/**
 * This is the model class for table "report".
 *
 * @property int $id
 * @property int $content_id
 * @property int|null $user_id
 * @property int $cause
 * @property string|null $description_cause
 * @property string|null $comment
 * @property int|null $resolved
 */
class Report extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%report}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_id', 'cause'], 'required'],
            [['content_id', 'user_id', 'cause', 'resolved'], 'integer'],
            [['comment'], 'string'],
            [['description_cause'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content_id' => 'Content ID',
            'user_id' => 'User ID',
            'cause' => 'Cause',
            'description_cause' => 'Description Cause',
            'comment' => 'Comment',
            'resolved' => 'Resolved',
        ];
    }
}
