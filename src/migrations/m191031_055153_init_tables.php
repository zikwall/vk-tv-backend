<?php

use yii\db\Migration;

class m191031_055153_init_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{playlist}}', [
            'id'     => $this->primaryKey(),
            'epg_id' => $this->integer(11)->notNull(),
            'name'   => $this->string(255)->notNull(),
            'url'    => $this->string(255)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{playlist}}');
    }
}
