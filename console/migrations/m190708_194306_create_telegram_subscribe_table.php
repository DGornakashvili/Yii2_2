<?php

use yii\db\Migration;

/**
 * Handles the creation of table `telegram_subscribe`.
 */
class m190708_194306_create_telegram_subscribe_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('telegram_subscribe', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'event_id' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('telegram_subscribe');
    }
}
