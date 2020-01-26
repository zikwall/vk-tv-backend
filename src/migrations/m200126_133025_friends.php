<?php

use yii\db\Migration;

/**
 * Class m200126_133025_friends
 */
class m200126_133025_friends extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%friendship}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'friend_user_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex('idx-friends', '{{%friendship}}', ['user_id', 'friend_user_id'], true);
        $this->addForeignKey('fk-user', '{{%friendship}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-friend', '{{%friendship}}', 'friend_user_id', '{{%user}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200126_133025_friends cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200126_133025_friends cannot be reverted.\n";

        return false;
    }
    */
}
