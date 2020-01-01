<?php

use yii\db\Migration;

class m200101_162754_add_image extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{playlist}}', 'image', $this->string(100)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200101_162754_add cannot be reverted.\n";

        return false;
    }
}
