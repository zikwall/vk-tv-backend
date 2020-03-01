<?php

use yii\db\Migration;

/**
 * Class m200301_092714_add_token_table
 */
class m200301_092714_add_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%token}}', [
            'user_id'    => $this->integer()->notNull(),
            'code'       => $this->string(32)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'type'       => $this->smallInteger()->notNull(),
        ], $this->tableOptions);

        $this->createIndex('{{%token_unique}}', '{{%token}}', ['user_id', 'code', 'type'], true);
        $this->addForeignKey('{{%fk_user_token}}', '{{%token}}', 'user_id', '{{%user}}', 'id', $this->cascade, $this->restrict);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200301_092714_add_token_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200301_092714_add_token_table cannot be reverted.\n";

        return false;
    }
    */
}
