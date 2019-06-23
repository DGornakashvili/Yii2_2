<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use yii\imagine\Image;
use yii\base\Exception;
use yii\web\UploadedFile;
use common\models\TaskAttachments;

class AttachmentsForm extends Model
{
	public $taskId;

	/** @var UploadedFile $file */
	public $upload;

	private $name;
	private $source;
	private $maxImgDir = '@images/tasks/max/';
	private $minImgDir = '@images/tasks/min/';

	public function rules()
	{
		return [
			[['taskId', 'upload'], 'required'],
			[['taskId'], 'integer'],
			[['upload'], 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'svg', 'gif']],
		];
	}

	/**
	 * @return bool
	 * @throws Exception
	 */
	public function save()
	{
		if ($this->validate()) {
			$this->initUpload();
			$this->minifyUpload();
			return $this->saveUpload();
		}

		return false;
	}

	public function attributeLabels()
	{
		return [
			'taskId' => Yii::t('app', 'task_name'),
			'upload' => Yii::t('app', 'task_upload'),
		];
	}


	/**
	 * @throws Exception
	 */
	public function initUpload()
	{
		$random = Yii::$app->security->generateRandomString(16);
		$this->name = $random . '.' . $this->upload->getExtension();
		$this->source = Yii::getAlias("{$this->maxImgDir}{$this->name}");
		$this->upload->saveAs($this->source);
	}

	public function minifyUpload()
	{
		Image::thumbnail($this->source, 80, 80)->save(Yii::getAlias("{$this->minImgDir}{$this->name}"));
	}

	private function saveUpload()
	{
		$model = new TaskAttachments(
			[
				'task_id' => $this->taskId,
				'source' => $this->name,
			]
		);

		return $model->save();
	}
}