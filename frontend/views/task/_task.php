<?php

use common\models\Comments;
use common\models\Tasks;
use common\models\TaskStatuses;
use common\models\User;
use frontend\models\forms\AttachmentsForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/**
 * @var Tasks $model
 * @var User $userId
 * @var User[] $users
 * @var Comments $commentsForm
 * @var TaskStatuses[] $statuses
 * @var AttachmentsForm $attachmentsForm
 */

Pjax::begin([
    'id' => 'task-pjax',
    'enablePushState' => false,
    'formSelector' => '#task-form'
]);

$task = ActiveForm::begin([
    'id' => 'task-form',
    'action' => Url::to(['task/save', 'id' => $model->id]),
    'options' => ['data-pjax' => true],
    'enableAjaxValidation' => true,
]);

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
Pjax::end();