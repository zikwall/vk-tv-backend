<?php


namespace zikwall\vktv\migrations;

use yii\db\Migration;

class m191201_113328_add_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // трансляция https
        $this->addColumn('{{playlist}}', 'ssl', $this->integer(1)->defaultValue(0));
        // ручное управление
        $this->addColumn('{{playlist}}', 'active', $this->integer(1)->defaultValue(1));
        // на случай, когда нужно срочно заблочить канал, например тоби пзд правообладатель пожаловался
        $this->addColumn('{{playlist}}', 'blocked', $this->integer(1)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
    }
}
