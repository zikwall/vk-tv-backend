<?php

use yii\db\Migration;

/**
 * Class m200216_083435_add_default_player
 */
class m200216_083435_add_default_player extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%content}}', 'default_player', $this->string(20)->null());
        $this->addColumn('{{%playlist}}', 'default_player', $this->string(20)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200216_083435_add_default_player cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200216_083435_add_default_player cannot be reverted.\n";

        return false;
    }
    */
}
