<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $name Название задачи
 * @property string $description
 * @property string $deadline
 * @property int $creator_id
 * @property int $responsible_id
 * @property int $status_id
 * @property string $created
 * @property string $updated
 *
 * @property Comments[] $comments
 * @property TaskAttachments[] $taskAttachments
 * @property User $creator
 * @property User $responsible
 * @property TaskStatuses $status
 */
class Tasks extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['deadline', 'created', 'updated'], 'safe'],
            [['creator_id', 'responsible_id', 'status_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['creator_id' => 'id']],
            [['responsible_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['responsible_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskStatuses::class, 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'task_name'),
            'description' => Yii::t('app', 'task_description'),
            'creator_id' => Yii::t('app', 'task_creator'),
            'responsible_id' => Yii::t('app', 'task_responsible'),
            'deadline' => Yii::t('app', 'task_deadline'),
            'status_id' => Yii::t('app', 'task_status'),
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['task_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTaskAttachments()
    {
        return $this->hasMany(TaskAttachments::class, ['task_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'creator_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getResponsible()
    {
        return $this->hasOne(User::class, ['id' => 'responsible_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(TaskStatuses::class, ['id' => 'status_id']);
    }
}
