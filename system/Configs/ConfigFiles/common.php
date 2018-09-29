<?php

return [
	'routerFiles' => [
		'routers',
		'api',
		'default',
	],
	'useCSRFToken' => true,
	'service' => [
		'autoLoad' => true,
	],
	'defaultTemplate' => 'default.html',
	'errors' => [
		'404' => 'errors/404.html',
		'503' => 'errors/503.html',
		'502' => 'errors/502.html'
	],
	'User' => 'User',
	'mysql' => [
		'DEV' => [
			'host'     => '127.0.0.1',
			'user'     => 'root',
			'database' => 'stdp_first',
			'password' => '11111111',
			'charset'  => 'utf8',
		],
		'TEST' => [
			'parent' => 'DEV',
		],
		'PROD' => [
			'parent' => 'DEV',
		],
	],
	'redis' => [
		'DEV' => [
			'host' => '127.0.0.1',
		],
		'TEST' => [
			'host' => '127.0.0.1',
		],
		'PROD' => [
			'host' => '127.0.0.1',
		]
	],
	'flashText' => [
		'cssStart'  => '<div class="alert alert-%s">',
		'cssEnd'    => '</div>',
		'isBigText' => true,
	]
];