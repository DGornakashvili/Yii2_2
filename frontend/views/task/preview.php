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
    <?= $this->render(
        '_task',
        [
            'model' => $model,
            'statuses' => $statuses,
            'users' => $users,
            'userId' => $userId,
        ]
    ); ?>
</div>
<hr>
<?= $this->render(
    '_upload',
    [
        'model' => $model,
        'attachmentsForm' => $attachmentsForm,
    ]
); ?>
<hr>
<div class="flex-container">
    <div class="comments-container">
        <?php
        $commentForm = ActiveForm::begin([
            'id' => 'comments-form',
            'action' => Url::to(['task/save-comment'])
        ]);
        
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
    <div class="all-comments">
        <?php foreach ($model->comments as $comment) : ?>

            <p><i><b><?= $comment->user->username ?>: </b></i><?= $comment->comment ?></p>
        
        <?php endforeach; ?>
    </div>
</div>
<script>
	var taskId = '<?=$model->id?>';
</script>