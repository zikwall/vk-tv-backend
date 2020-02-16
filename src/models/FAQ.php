<?php

namespace vktv\models;

use yii\db\ActiveRecord;

class FAQ extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%faq}}';
    }
}
