<?php

use yii\db\Migration;

/**
 * Class m200212_114914_add_ad_url_content_and_playlist
 */
class m200212_114914_add_ad_url_content_and_playlist extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%content}}', 'ad_url', $this->string(255)->null());
        $this->addColumn('{{%playlist}}', 'ad_url', $this->string(255)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200212_114914_add_ad_url_content_and_playlist cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200212_114914_add_ad_url_content_and_playlist cannot be reverted.\n";

        return false;
    }
    */
}
