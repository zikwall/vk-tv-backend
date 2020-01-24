<?php

use yii\db\Migration;

/**
 * Class m200124_124030_add_user_playlist
 */
class m200124_124030_add_user_playlist extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%content}}', [
            'id'            => $this->primaryKey(),
            'user_id'       => $this->integer()->notNull(),
            'type'          => $this->integer(5)->notNull(),
            'category'      => $this->integer(5)->notNull(),
            'name'          => $this->string(100)->notNull(),
            'image'         => $this->string(255)->null(),
            'desc'          => $this->text()->null(),
            'rating'        => $this->float(2)->null(),
            'age_limit'     => $this->integer(2)->null(),
            'created_at'    => $this->integer(11)->null(),
            'updated_at'    => $this->integer(11)->null()
        ]);
        
        $this->createTable('{{%like}}', [
            'id'            => $this->primaryKey(),
            'user_id'       => $this->integer()->notNull(),
            'content_id'    => $this->integer()->notNull(),
            'liket_at'      => $this->integer(11)->null()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200124_124030_add_user_playlist cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200124_124030_add_user_playlist cannot be reverted.\n";

        return false;
    }
    */
}
