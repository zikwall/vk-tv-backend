<?php

use yii\db\Migration;

/**
 * Class m200209_180448_add_own_player_url_and_user_origin
 */
class m200209_180448_add_own_player_url_and_user_origin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%content}}', 'own_player_url', $this->text()->null()->after('desc'));
        $this->addColumn('{{%content}}', 'use_own_player_url', $this->integer(1)->defaultValue(0)->after('desc'));
        $this->addColumn('{{%content}}', 'use_origin', $this->integer(1)->defaultValue(0)->after('own_player_url'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200209_180448_add_own_player_url_and_user_origin cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200209_180448_add_own_player_url_and_user_origin cannot be reverted.\n";

        return false;
    }
    */
}
