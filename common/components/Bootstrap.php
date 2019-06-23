<?php


namespace common\components;

use Yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
	public function bootstrap($app)
	{
		$this->initLanguage();
	}

	private function initLanguage()
	{
		if ($lang = Yii::$app->session->get('language')) {
			Yii::$app->language = $lang;
		}
	}
}