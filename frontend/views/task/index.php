<style>
    .task-preview {
        border: 1px solid #1b1e21;
        margin-bottom: 15px;
        padding: 5px;
        width: 80%;
    }

    .task-preview_link {
        display: flex;
        width: 100%;
        padding: 10px 0;
        text-align: center;
        color: #1b1e21;
        text-decoration: none !important;
    }

    .task-preview_link:hover {
        color: #ea3430;
    }

    .task-preview_text {
        width: 25%;
    }
    
    #w0 {
        display: flex;
    }

    .btn-primary {
        align-self: center;
        height: 34px;
        margin-left: 15px;
    }
</style>
<?php

use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use frontend\widgets\TasksPreview;

/**
 * @var ActiveDataProvider $dataProvider
 * @var ActiveDataProvider $searchModel
 */

echo $this->render('_search', ['model' => $searchModel]);

echo ListView::widget([
	'dataProvider' => $dataProvider,
	'itemView' => function ($model) {
		return TasksPreview::widget(['model' => $model]);
	},
	'summary' => false,
	'options' => [
		'class' => 'tasks-container'
	]
]);