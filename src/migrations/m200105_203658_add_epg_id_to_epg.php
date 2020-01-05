<?php

use yii\db\Migration;

/**
 * Class m200105_203658_add_epg_id_to_epg
 */
class m200105_203658_add_epg_id_to_epg extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%epg}}', 'epg_id', $this->integer(5));
        $this->addColumn('{{%epg}}', 'from', $this->string(10)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200105_203658_add_epg_id_to_epg cannot be reverted.\n";

        return false;
    }
}
