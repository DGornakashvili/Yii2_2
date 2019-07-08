<?php

use yii\db\Migration;

/**
 * Handles the creation of table `projects`.
 */
class m190708_200940_create_projects_table extends Migration
{
    protected $tableName = 'projects';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('projects', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
        
        $tasksTable = 'tasks';
        
        $this->addForeignKey('fk_task_project', $tasksTable, 'project_id', $this->tableName, 'id');
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('projects');
    }
}
