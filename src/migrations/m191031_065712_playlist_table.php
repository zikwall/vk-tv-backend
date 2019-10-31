<?php

use yii\db\Migration;

/**
 * Class m191031_065712_playlist_table
 */
class m191031_065712_playlist_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{playlist}}', 'name', 'VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191031_065712_playlist_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191031_065712_playlist_table cannot be reverted.\n";

        return false;
    }
    */
}
