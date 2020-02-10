<?php

use yii\db\Migration;

/**
 * Class m200210_133409_add_content_id_and_user_id_playlist
 */
class m200210_133409_add_content_id_and_user_id_playlist extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%playlist}}', 'content_id', $this->integer()->null()->after('epg_id'));
        $this->addColumn('{{%playlist}}', 'user_id', $this->integer()->null()->after('epg_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200210_133409_add_content_id_and_user_id_playlist cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200210_133409_add_content_id_and_user_id_playlist cannot be reverted.\n";

        return false;
    }
    */
}
