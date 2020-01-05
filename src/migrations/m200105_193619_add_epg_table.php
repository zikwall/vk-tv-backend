<?php

use yii\db\Migration;

/**
 * Class m200105_193619_add_epg_table
 */
class m200105_193619_add_epg_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%epg}}', [
            'id'        => $this->primaryKey(),
            'day_begin' => $this->integer(11)->notNull(),
            'tz'        => $this->integer(2)->null(),
            'start'     => $this->integer(11)->notNull(),
            'stop'      => $this->integer(11)->notNull(),
            'title'     => $this->string()->notNull(),
            'desc'      => $this->text()->null()
        ]);
        
        $this->createIndex('epg_day_index', '{{%epg}}', 'day_begin');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200105_193619_add_epg_table cannot be reverted.\n";

        return false;
    }
}
