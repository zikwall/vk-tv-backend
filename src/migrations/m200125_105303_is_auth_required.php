<?php

use yii\db\Migration;

/**
 * Class m200125_105303_is_auth_required
 */
class m200125_105303_is_auth_required extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%content}}', 'is_auth_required', $this->integer(1)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200125_105303_is_auth_required cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200125_105303_is_auth_required cannot be reverted.\n";

        return false;
    }
    */
}
