<?php

use yii\db\Migration;

/**
 * Class m200104_195222_avatar_profile
 */
class m200104_195222_avatar_profile extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%profile}}', 'avatar', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200104_195222_avatar_profile cannot be reverted.\n";

        return false;
    }
}
