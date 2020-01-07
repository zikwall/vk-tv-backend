<?php

use yii\db\Migration;

/**
 * Class m200107_110759_add_category
 */
class m200107_110759_add_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%playlist}}', 'category', $this->integer(4)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200107_110759_add_category cannot be reverted.\n";

        return false;
    }

}
