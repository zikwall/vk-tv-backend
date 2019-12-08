<?php

use yii\db\Migration;

/**
 * Class m191208_112503_add_user
 */
class m191208_112503_add_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(25)->notNull(),
            'email' => $this->string()->notNull(),
            'password_hash' => $this->string(60)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'confirmed_at' =>$this->integer(),
            'blocked_at' => $this->integer(),
            'registration_ip' => $this->string()->null(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('user_unique_username', '{{%user}}', 'username', true);
        $this->createIndex('user_unique_email', '{{%user}}', 'email', true);

        $this->createTable('{{%profile}}', [
            'user_id'        => $this->primaryKey(),
            'name'           => $this->string(),
            'public_email'   => $this->string(),
        ]);

        $this->addForeignKey(
            'fk_user_profile',
            '{{%profile}}', 'user_id',
            '{{%user}}', 'id',
            'CASCADE', 'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user_profile', '{{%profile}}');
        $this->dropTable('{{%profile}}');
        $this->dropTable('{{%user}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191208_112503_add_user cannot be reverted.\n";

        return false;
    }
    */
}
