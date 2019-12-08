<?php


namespace vktv\models;

use yii\db\ActiveRecord;

class Profile extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'bioString'            => ['bio', 'string'],
            'publicEmailPattern'   => ['public_email', 'email'],
            'gravatarEmailPattern' => ['gravatar_email', 'email'],
            'websiteUrl'           => ['website', 'url'],
            'nameLength'           => ['name', 'string', 'max' => 255],
            'publicEmailLength'    => ['public_email', 'string', 'max' => 255],
            'gravatarEmailLength'  => ['gravatar_email', 'string', 'max' => 255],
            'locationLength'       => ['location', 'string', 'max' => 255],
            'websiteLength'        => ['website', 'string', 'max' => 255],
        ];
    }


    public function attributeLabels()
    {
        return [
            'name'           => \Yii::t('user', 'Name'),
            'public_email'   => \Yii::t('user', 'Email (public)'),
            'gravatar_email' => \Yii::t('user', 'Gravatar email'),
            'location'       => \Yii::t('user', 'Location'),
            'website'        => \Yii::t('user', 'Website'),
            'bio'            => \Yii::t('user', 'Bio'),
        ];
    }
}
