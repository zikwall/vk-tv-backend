<?php

use yii\db\Migration;

/**
 * Class m200220_112505_add_tags_content_field
 */
class m200220_112505_add_tags_content_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%content}}', 'tags', $this->string(255)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200220_112505_add_tags_content_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200220_112505_add_tags_content_field cannot be reverted.\n";

        return false;
    }
    */
}
