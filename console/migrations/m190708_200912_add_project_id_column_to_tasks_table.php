<?php

use yii\db\Migration;

/**
 * Handles adding project_id to table `tasks`.
 */
class m190708_200912_add_project_id_column_to_tasks_table extends Migration
{
    protected $tableName = 'tasks';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'project_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'project_id');
    }
}
