<?php

namespace vktv\models;

use Yii;

/**
 *
 * @property int $id
 * @property int $epg_id
 * @property string $name
 * @property string $url
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
            [['epg_id', 'name', 'url'], 'required'],
            [['epg_id'], 'integer'],
            [['name', 'url'], 'string', 'max' => 255],
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
