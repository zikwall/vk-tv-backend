<?php

use yii\db\Migration;

/**
 * Class m200105_194858_add_epg_id_to_playlist
 */
class m200105_194858_add_epg_id_to_playlist extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%playlist}}', 'xmltv_id', $this->integer(5)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200105_194858_add_epg_id_to_playlist cannot be reverted.\n";

        return false;
    }
    
}
