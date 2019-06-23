<?php

use yii\db\Migration;
use common\models\User;

/**
 * Handles the creation of table `tasks`.
 */
class m190525_084651_create_tasks_table extends Migration
{
    private $tableName = 'tasks';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tasks', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->comment("Название задачи"),
            'description' => $this->string(),
            'deadline' => $this->date(),
            'creator_id' => $this->integer(),
            'responsible_id' => $this->integer(),
            'status_id' => $this->integer(),
            'created' => $this->date(),
            'updated' => $this->date(),
        ]);
        
        $userTable = User::tableName();
        
        $this->createIndex("tasks_creator_idx", 'tasks', ['creator_id']);
        $this->createIndex("tasks_responsible_idx", 'tasks', ['responsible_id']);
        
        $this->addForeignKey('fk_task_creator', $this->tableName, 'creator_id', $userTable, 'id');
        $this->addForeignKey('fk_task_responsible', $this->tableName, 'responsible_id', $userTable, 'id');
   }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tasks');
    }
}
