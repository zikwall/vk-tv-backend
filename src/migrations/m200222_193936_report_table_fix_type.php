<?php

use yii\db\Migration;

/**
 * Class m200222_193936_report_table_fix_type
 */
class m200222_193936_report_table_fix_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%report}}', 'cause', $this->string(100)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200222_193936_report_table_fix_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200222_193936_report_table_fix_type cannot be reverted.\n";

        return false;
    }
    */
}
