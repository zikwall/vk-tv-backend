<?php

namespace vktv\models;

use Yii;

/**
 * This is the model class for table "playlist".
 *
 * @property int $id
 * @property int $epg_id
 * @property int|null $user_id
 * @property int|null $content_id
 * @property string $name
 * @property string $url
 * @property int|null $ssl
 * @property int|null $active
 * @property int|null $blocked
 * @property string|null $image
 * @property int $use_origin
 * @property int|null $xmltv_id
 * @property int $category
 * @property string|null $ad_url
 */
class Playlist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{playlist}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['epg_id', 'name', 'url', 'category'], 'required'],
            [['epg_id', 'user_id', 'content_id', 'ssl', 'active', 'blocked', 'use_origin', 'xmltv_id', 'category'], 'integer'],
            [['name', 'url', 'ad_url'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 100],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'epg_id' => 'Epg ID',
            'name' => 'Name',
            'url' => 'Url',
        ];
    }
    
    public function toHistory()
    {
        
    }
}
