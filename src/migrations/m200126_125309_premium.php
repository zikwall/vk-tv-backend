<?php

use yii\db\Migration;

/**
 * Class m200126_125309_premium
 */
class m200126_125309_premium extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%premium_key}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string(20)->notNull(),
            'expired' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200126_125309_premium cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200126_125309_premium cannot be reverted.\n";

        return false;
    }
    */
}
