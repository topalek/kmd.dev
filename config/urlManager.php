<?php

/** @var array $params */
return [
	'class' => 'yii\web\UrlManager',
	//'hostInfo' => $params['backendHostInfo'],
	'baseUrl' => '',
	'enablePrettyUrl' => true,
	'showScriptName' => false,
	'rules' => [
		'' => 'site/index',
		'contact' => 'contact/index',
		'signup' => 'auth/signup/request',
		'signup/<_a:[\w\-]+>' => 'auth/signup/<_a>',
		'<_a:login|logout>' => 'auth/auth/<_a>',

		'<_c:[\w\-]+>' => '<_c>/index',
		'<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
		'<_c:[\w\-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
		'<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_c>/<_a>',
	],
];
