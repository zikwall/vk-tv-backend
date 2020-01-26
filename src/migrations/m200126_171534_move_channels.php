<?php

use yii\db\Migration;

/**
 * Class m200126_171534_move_channels
 */
class m200126_171534_move_channels extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%content}}', 'active', $this->integer(1)->defaultValue(1));
        $this->addColumn('{{%content}}', 'blocked', $this->integer(1)->defaultValue(0));

        $channels = (new \yii\db\Query())
            ->select('*')
            ->from('{{%playlist}}')
            ->where(['is not' ,'image', new \yii\db\Expression('NULL')])
            ->all();

        $items = [];

        foreach ($channels as $channel) {
            $items[] = [
                'user_id'           => 2,
                'url'               => $channel['url'],
                'type'              => \zikwall\vktv\constants\Content::TYPE_CHANNEL,
                'category'          => $channel['category'],
                'name'              => $channel['name'],
                'image'             => $channel['image'],
                'desc'              => '',
                'rating'            => 0,
                'age_limit'         => 0,
                'created_at'        => time(),
                'updated_at'        => 0,
                'is_auth_required'  => 1,
                'visibility'        => \zikwall\vktv\constants\Content::VISIBILITY_PUBLIC,
                'pinned'            => \zikwall\vktv\constants\Content::CONTENT_NOTPINNED,
                'archived'          => \zikwall\vktv\constants\Content::CONTENT_NOTARCHIVED,
                'active'            => 1,
                'blocked'           => 0
            ];
        }

        if (!empty($items)) {
            Yii::$app->getDb()->createCommand()->batchInsert('{{%content}}',
                [
                    'user_id', 'url', 'type', 'category', 'name', 'image',
                    'desc', 'rating', 'age_limit', 'created_at', 'updated_at',
                    'is_auth_required', 'visibility', 'pinned', 'archived', 'active', 'blocked'
                ],
                $items
            )->execute();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200126_171534_move_channels cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200126_171534_move_channels cannot be reverted.\n";

        return false;
    }
    */
}
