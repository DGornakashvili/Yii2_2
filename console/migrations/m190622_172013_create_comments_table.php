<?php

use yii\db\Migration;
use common\models\User;

/**
 * Handles the creation of table `comments`.
 */
class m190622_172013_create_comments_table extends Migration
{
	protected $tableName = 'comments';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comments', [
            'id' => $this->primaryKey(),
	        'user_id' => $this->integer(),
	        'task_id' => $this->integer(),
	        'comment' => $this->string(),
        ]);

	    $usersTable = User::tableName();
	    $tasksTable = 'tasks';

	    $this->addForeignKey('fk_user_comments', $this->tableName, 'user_id', $usersTable, 'id');
	    $this->addForeignKey('fk_task_comments', $this->tableName, 'task_id', $tasksTable, 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('comments');
    }
}
