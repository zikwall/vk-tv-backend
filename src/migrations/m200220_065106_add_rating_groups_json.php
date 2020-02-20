<?php

use yii\db\Migration;

/**
 * Class m200220_065106_add_rating_groups_json
 */
class m200220_065106_add_rating_groups_json extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%content}}', 'rating_groups', $this->string(255)->defaultValue('{}'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200220_065106_add_rating_groups_json cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200220_065106_add_rating_groups_json cannot be reverted.\n";

        return false;
    }
    */
}
