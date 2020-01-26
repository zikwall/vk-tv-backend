<?php

use yii\db\Migration;

/**
 * Class m200126_142121_content_url
 */
class m200126_142121_content_url extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%content}}', 'url', $this->string(255)->notNull()->after('user_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200126_142121_content_url cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200126_142121_content_url cannot be reverted.\n";

        return false;
    }
    */
}
