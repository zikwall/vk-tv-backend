<?php

use yii\db\Migration;

/**
 * Class m200212_120232_init_review_and_rating_tables
 */
class m200212_120232_init_review_and_rating_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%review}}', [
            'id' => $this->primaryKey(),
            'content_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'content' => $this->string(255)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'value' => $this->integer(1)->notNull()
        ]);

        $this->createTable('{{%review_useful}}', [
            'id' => $this->primaryKey(),
            'review_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'value' => $this->integer(1)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200212_120232_init_review_and_rating_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200212_120232_init_review_and_rating_tables cannot be reverted.\n";

        return false;
    }
    */
}
