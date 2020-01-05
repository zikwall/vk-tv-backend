<?php

namespace vktv\models;

use Yii;

class Epg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%epg}}';
    }
}
