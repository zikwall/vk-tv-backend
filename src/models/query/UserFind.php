<?php

namespace vktv\models\query;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class UserFind extends ActiveQuery
{
    public function isActive()
    {
        return $this->where(['is_destroyed' => 0]);
    }
    
    /**
     * @param $usernameOrEmail
     * @return array|\yii\db\ActiveRecord|null
     */
    public function findUserByUsernameOrEmail(string $usernameOrEmail)
    {
        if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
            return $this->findUserByEmail($usernameOrEmail);
        }

        return $this->findUserByUsername($usernameOrEmail);
    }

    /**
     * @param $username
     * @return array|\yii\db\ActiveRecord|null
     */
    public function findUserByUsername(string $username)
    {
        return $this->findUser(['username' => $username])->one();
    }

    /**
     * @param $email
     * @return array|\yii\db\ActiveRecord|null
     */
    public function findUserByEmail(string $email)
    {
        return $this->findUser(['email' => $email])->one();
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord|null
     */
    public function findUserById(int $id)
    {
        return $this->findUser(['id' => $id])->one();
    }

    /**
     * @param $condition
     * @return UserFind
     */
    public function findUser($condition) : UserFind
    {
        return $this->where($condition);
    }
}
