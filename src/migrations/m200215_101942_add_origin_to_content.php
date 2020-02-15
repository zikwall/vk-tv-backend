<?php

use yii\db\Migration;

/**
 * Class m200215_101942_add_origin_to_content
 */
class m200215_101942_add_origin_to_content extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%content}}', 'enable_origin', $this->integer(1)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200215_101942_add_origin_to_content cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200215_101942_add_origin_to_content cannot be reverted.\n";

        return false;
    }
    */
}
