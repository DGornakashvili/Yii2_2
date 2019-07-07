<?php

use common\models\Tasks;
use frontend\models\forms\AttachmentsForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/**
 * @var Tasks $model
 * @var AttachmentsForm $attachmentsForm
 */

Pjax::begin([
    'id' => 'upload-pjax',
    'enablePushState' => false,
    'formSelector' => '#upload-form'
]);
?>

<div class="attachments-container">
    <div class="upload-container">
        <?php
        $uploadForm = ActiveForm::begin([
            'id' => 'upload-form',
            'action' => Url::to(['task/save-attachment']),
            'options' => [
                'data-pjax' => true,
                'enctype' => 'multipart/form-data'
            ],
            'enableAjaxValidation' => false,
        ]);
        
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
    <div class="all-attachments">
        <?php foreach ($model->taskAttachments as $attachment) : ?>

            <a href="/images/tasks/max/<?= $attachment->source ?>">
                <img src="/images/tasks/min/<?= $attachment->source ?>" alt="attached image">
            </a>
        
        <?php endforeach; ?>
    </div>
</div>
<?php Pjax::end(); ?>