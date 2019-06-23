<?php

namespace frontend\widgets;

use Exception;
use yii\base\Widget;
use common\models\Tasks;

class TasksPreview extends Widget
{
	public $model;

	/**
	 * @return string
	 * @throws Exception
	 */
	public function run()
	{
		if (is_a($this->model, Tasks::class)) {
			return $this->render('tasksPreview', ['model' => $this->model]);
		}
		throw new Exception("Ошибка: Допустимая модель - " . Tasks::class);
	}
}