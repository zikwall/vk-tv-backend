<?php

use yii\db\Migration;
use \zikwall\vktv\constants\Content;

/**
 * Class m200126_102721_add_visibility_content
 */
class m200126_102721_add_visibility_content extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // default public
        $this->addColumn('{{%content}}', 'visibility', $this->integer(2)->defaultValue(Content::VISIBILITY_PUBLIC));
        $this->addColumn('{{%content}}', 'pinned', $this->integer(1)->defaultValue(Content::CONTENT_NOTPINNED));
        $this->addColumn('{{%content}}', 'archived', $this->integer(1)->defaultValue(Content::CONTENT_NOTARCHIVED));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200126_102721_add_visibility_content cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200126_102721_add_visibility_content cannot be reverted.\n";

        return false;
    }
    */
}
