<?php

use yii\db\Migration;

/**
 * Class m191223_134714_add_destroyed_fields
 */
class m191223_134714_add_destroyed_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'destroyed_at', $this->integer()->null());
        $this->addColumn('{{%user}}', 'is_destroy', $this->integer(1)->defaultValue(0)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191223_134714_add_destroyed_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191223_134714_add_destroyed_fields cannot be reverted.\n";

        return false;
    }
    */
}
