<?php

namespace vktv\models;

use Yii;

/**
 * This is the model class for table "content".
 *
 * @property int $id
 * @property int $user_id
 * @property string $url
 * @property int $type
 * @property int $category
 * @property string $name
 * @property string|null $image
 * @property string|null $desc
 * @property int|null $use_own_player_url
 * @property string|null $own_player_url
 * @property int|null $use_origin
 * @property float|null $rating
 * @property int|null $age_limit
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $is_auth_required
 * @property int|null $visibility
 * @property int|null $pinned
 * @property int|null $archived
 * @property int|null $active
 * @property int|null $blocked
 * @property string|null $ad_url
 */
class Content extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%content}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'url', 'type', 'category', 'name'], 'required'],
            [['user_id', 'type', 'category', 'use_own_player_url', 'use_origin', 'age_limit', 'created_at', 'updated_at', 'is_auth_required', 'visibility', 'pinned', 'archived', 'active', 'blocked'], 'integer'],
            [['desc', 'own_player_url'], 'string'],
            [['rating'], 'number'],
            [['url', 'image', 'ad_url'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'url' => 'Url',
            'type' => 'Type',
            'category' => 'Category',
            'name' => 'Name',
            'image' => 'Image',
            'desc' => 'Desc',
            'use_own_player_url' => 'Use Own Player Url',
            'own_player_url' => 'Own Player Url',
            'use_origin' => 'Use Origin',
            'rating' => 'Rating',
            'age_limit' => 'Age Limit',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_auth_required' => 'Is Auth Required',
            'visibility' => 'Visibility',
            'pinned' => 'Pinned',
            'archived' => 'Archived',
            'active' => 'Active',
            'blocked' => 'Blocked',
        ];
    }
}
