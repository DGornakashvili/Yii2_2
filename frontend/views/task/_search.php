<?php

use yii\web\View;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\filters\TasksFilter;

/* @var $this View */
/* @var $model TasksFilter */
/* @var $form ActiveForm */
?>

<div class="tasks-search">

	<?php
    $form = ActiveForm::begin();

	$dates = [];
	for ($i = 1; $i <= 12; $i++) {
	    $dates[$i] = date('F', strtotime(date('Y') . "-$i"));
	}

	echo $form->field($model, 'created')->label('Filter')->dropDownList($dates);

	echo Html::submitButton('Find', ['class' => 'btn btn-primary']);

	ActiveForm::end();
	?>

</div>
