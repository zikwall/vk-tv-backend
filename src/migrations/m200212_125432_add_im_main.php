<?php

use yii\db\Migration;

/**
 * Class m200212_125432_add_im_main
 */
class m200212_125432_add_im_main extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%content}}', 'in_main', $this->integer(1)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200212_125432_add_im_main cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200212_125432_add_im_main cannot be reverted.\n";

        return false;
    }
    */
}
