<?php

use yii\db\Migration;

/**
 * Class m200126_134320_friends_datetime
 */
class m200126_134320_friends_datetime extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%friendship}}', 'created_at', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200126_134320_friends_datetime cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200126_134320_friends_datetime cannot be reverted.\n";

        return false;
    }
    */
}
