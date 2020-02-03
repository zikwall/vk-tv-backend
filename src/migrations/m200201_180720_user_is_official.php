<?php

use yii\db\Migration;

/**
 * Class m200201_180720_user_is_official
 */
class m200201_180720_user_is_official extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'is_official', $this->integer(1)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200201_180720_user_is_official cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200201_180720_user_is_official cannot be reverted.\n";

        return false;
    }
    */
}
