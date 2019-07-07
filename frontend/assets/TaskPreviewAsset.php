<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class TaskPreviewAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';

	public $css = [
		'css/taskPreview.css',
	];
	
	public $js = [
	    'js/chat.js'
    ];

	public $depends = [
		'frontend\assets\AppAsset',
	];
}