<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "telegram_subscribe".
 *
 * @property int $id
 * @property int $user_id
 * @property string $event_id
 */
class TelegramSubscribe extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_subscribe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['event_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'event_id' => 'Event ID',
        ];
    }
}
