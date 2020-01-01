<?php

use yii\db\Migration;

/**
 * Class m200101_171642_add_use_origin
 */
class m200101_171642_add_use_origin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{playlist}}', 'use_origin',  $this->integer(1)->defaultValue(0)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200101_171642_add_use_origin cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200101_171642_add_use_origin cannot be reverted.\n";

        return false;
    }
    */
}
