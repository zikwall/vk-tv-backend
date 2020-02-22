<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%report}}`.
 */
class m200222_190552_create_report_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%report}}', [
            'id' => $this->primaryKey(),
            'content_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->null(),
            'cause' => $this->integer()->notNull(),
            'description_cause' => $this->string(100)->null(),
            'comment' => $this->text()->null(),
            'resolved' => $this->integer(1)->defaultValue(0)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%report}}');
    }
}
