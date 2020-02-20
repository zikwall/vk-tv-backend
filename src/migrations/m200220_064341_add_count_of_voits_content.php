<?php

use yii\db\Migration;

/**
 * Class m200220_064341_add_count_of_voits_content
 */
class m200220_064341_add_count_of_voits_content extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%content}}', 'votes', $this->integer(11)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200220_064341_add_count_of_voits_content cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200220_064341_add_count_of_voits_content cannot be reverted.\n";

        return false;
    }
    */
}
