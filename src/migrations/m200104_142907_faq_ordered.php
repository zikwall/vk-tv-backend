<?php

use yii\db\Migration;

/**
 * Class m200104_142907_faq_ordered
 */
class m200104_142907_faq_ordered extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%faq}}', 'order', $this->integer()->null());
        $this->getDb()->createCommand('UPDATE `faq` SET `order` = `id`')->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200104_142907_faq_ordered cannot be reverted.\n";

        return false;
    }
}
