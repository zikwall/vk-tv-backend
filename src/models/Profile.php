<?php


namespace vktv\models;

use Yii;
use zikwall\vktv\helpers\Image;
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
            'publicEmailPattern'   => ['public_email', 'email'],
            'nameLength'           => ['name', 'string', 'max' => 255],
            'publicEmailLength'    => ['public_email', 'string', 'max' => 255],
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

    public function updateProfile($name, $email, $avatar)
    {
        $userUploadDir = Yii::getAlias('@app') . '/web/user/avatars/';
        $savedFile = '';

        if ($name) {
            $this->name = $name;
        }

        if ($email) {
            $this->public_email = $email;
        }

        if ($avatar) {
            if (!empty($this->avatar)) {
                $avatarSplits = explode('/', $this->avatar);
                $dbAvatar = $avatarSplits[6];

                if (!empty($dbAvatar)) {
                    $file = $userUploadDir . $dbAvatar;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            }

            $avatarFilePath = Yii::getAlias('@app') . '/web/user/avatars';
            $savedFile = Image::base64ToJPEG($avatar, $avatarFilePath, true);
            $this->avatar = sprintf('http://tv.zikwall.ru/web/user/avatars/%s.jpg', $savedFile);
        }

        if (!$this->save()) {
            if (!empty($savedFile)) {
                $file = $userUploadDir . $savedFile . '.jpg';

                if (file_exists($file)) {
                    unlink($file);
                }
            }

            return false;
        }

        return true;
    }
}
