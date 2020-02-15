<?php

namespace vktv\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property int $content_id
 * @property int $user_id
 * @property string $content
 * @property int $created_at
 * @property int $value
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%review}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_id', 'user_id', 'content', 'created_at', 'value'], 'required'],
            [['content_id', 'user_id', 'created_at', 'value'], 'integer'],
            [['content'], 'string', 'max' => 255],
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
            'content' => 'Content',
            'created_at' => 'Created At',
            'value' => 'Value',
        ];
    }
    
    public function afterDelete()
    {
        $relatedReviews = ReviewUseful::find()->where([
            'review_id' => $this->id,
            'user_id' => $this->user_id
        ]);

        foreach ($relatedReviews->all() as $record) {
            $record->delete();
        }

        parent::afterDelete();
    }
}
