<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Tasks;
use common\models\User;
use common\models\Comments;
use common\models\TaskStatuses;
use frontend\assets\TaskPreviewAsset;
use frontend\models\forms\AttachmentsForm;

TaskPreviewAsset::register($this);

/**
 * @var Tasks $model
 * @var User $userId
 * @var User[] $users
 * @var Comments $commentsForm
 * @var TaskStatuses[] $statuses
 * @var AttachmentsForm $attachmentsForm
 */
?>
<div class="form-container">
	<?php
	$task = ActiveForm::begin(['action' => Url::to(['task/save', 'id' => $model->id])]);

	echo $task
		->field($model, 'name')
		->textInput(['class' => 'form-input form-input__name']);

	echo $task
		->field($model, 'status_id')
		->dropDownList($statuses, ['class' => 'form-input form-input__status']);

	echo $task
		->field($model, 'creator_id')
		->dropDownList($users, ['class' => 'form-input form-input__creator']);

	echo $task
		->field($model, 'description')
		->textInput(['class' => 'form-input form-input__description']);

	echo $task
		->field($model, 'responsible_id')
		->dropDownList($users, ['class' => 'form-input form-input__responsible']);

	echo $task
		->field($model, 'deadline')
		->input('date', ['class' => 'form-input form-input__deadline']);

	echo Html::submitButton('Подтвердить', ['class' => 'btn btn-success']);

	ActiveForm::end();
	?>
</div>
<hr>
<div class="attachments-container">
    <div class="comments-container">
		<?php
		$commentForm = ActiveForm::begin(['action' => Url::to(['task/save-comment'])]);

		echo $commentForm
			->field($commentsForm, 'task_id')
			->hiddenInput(['value' => $model->id])->label(false);

		echo $commentForm
			->field($commentsForm, 'user_id')
			->hiddenInput(['value' => $userId])->label(false);

		echo $commentForm
			->field($commentsForm, 'comment')
			->textarea(['class' => 'form-input form-input__description']);

		echo Html::submitButton('Добавить', ['class' => 'btn btn-default']);

		ActiveForm::end();
		?>
    </div>
    <div class="upload-container">
		<?php
		$uploadForm = ActiveForm::begin(['action' => Url::to(['task/save-attachment'])]);

		echo $uploadForm
			->field($attachmentsForm, 'taskId')
			->hiddenInput(['value' => $model->id])->label(false);

		echo $uploadForm
			->field($attachmentsForm, 'upload')
			->fileInput();

		echo Html::submitButton('Загрузить', ['class' => 'btn btn-default']);

		ActiveForm::end();
		?>
    </div>
</div>
<hr>
<div class="flex-container">
    <div class="all-comments">
		<?php foreach ($model->comments as $comment) : ?>

            <p><i><b><?= $comment->user->username ?>: </b></i><?= $comment->comment ?></p>

		<?php endforeach; ?>
    </div>
    <div class="all-attachments">
		<?php foreach ($model->taskAttachments as $attachment) : ?>

            <a href="/images/tasks/max/<?= $attachment->source ?>">
                <img src="/images/tasks/min/<?= $attachment->source ?>" alt="attached image">
            </a>

		<?php endforeach; ?>
    </div>
</div>
<script>
    var taskId = '<?=$model->id?>';
</script>