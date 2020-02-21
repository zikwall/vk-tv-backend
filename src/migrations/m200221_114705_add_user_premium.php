<?php

use yii\db\Migration;

/**
 * Class m200221_114705_add_user_premium
 */
class m200221_114705_add_user_premium extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%premium_key}}', 'activation_count_limit', $this->integer()->defaultValue(1));
        $this->addColumn('{{%premium_key}}', 'activation_time_limit', $this->integer(11)->null());

        $this->createTable('{{%user_premium}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'key_id' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200221_114705_add_user_premium cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200221_114705_add_user_premium cannot be reverted.\n";

        return false;
    }
    */
}
