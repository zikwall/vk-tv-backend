<?php

use yii\db\Migration;

/**
 * Class m200125_105657_add_device_id_user
 */
class m200125_105657_add_device_id_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'first_device_id', $this->string(100)->notNull());
        $this->addColumn('{{%user}}', 'is_premium', $this->integer(1)->defaultValue(0));
        $this->addColumn('{{%user}}', 'premium_ttl', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200125_105657_add_device_id_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200125_105657_add_device_id_user cannot be reverted.\n";

        return false;
    }
    */
}
