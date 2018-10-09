<?php

return [
	'routerFiles' => [
		'customRoutersApp' => 'routersFiles'
	],
	'useCSRFToken' => true,
	'service' => [
		'autoLoad' => true,
	],
	'errors' => [
		'404' => 'errors/404.html',
		'503' => 'errors/503.html',
		'502' => 'errors/502.html',
		'500' => 'errors/500.html',
	],
	'maxAuthUserWithDevices' => 10,
	'mysql' => [
		'read' => [
			[
				'host'     => '127.0.0.1:3307',
				'user'     => 'root',
				'database' => 'es-framework',
				'password' => '234679',
				'charset'  => 'utf8'
			],[
				'host'     => '127.0.0.1:3309',
				'user'     => 'root',
				'database' => 'es-framework',
				'password' => '234679',
				'charset'  => 'utf8'
			]
		],
		'write' => [
			'host'     => '127.0.0.1',
			'user'     => 'root',
			'database' => 'teacher',
			'password' => '234679',
			'charset'  => 'utf8'
		]
	],
	'pgsql' => [
		'read' => [
			[
				'host'     => '127.0.0.1',
				'user'     => 'root',
				'database' => 'teacher',
				'password' => '234679',
				'charset'  => 'utf8'
			]
		],
		'write' => [
			'host'     => '127.0.0.1',
			'user'     => 'root',
			'database' => 'teacher',
			'password' => '234679',
			'charset'  => 'utf8'
		]
	],
	'oracle' => [
		'read' => [
			[
				'host'     => '127.0.0.1',
				'user'     => 'root',
				'database' => 'teacher',
				'password' => '23467',
				'charset'  => 'utf8'
			]
		],
		'write' => [
			'host'     => '127.0.0.1',
			'user'     => 'root',
			'database' => 'teacher',
			'password' => '234679',
			'charset'  => 'utf8'
		]
	],
	'mssql' => [
		'read' => [
			[
				'host'     => '127.0.0.1',
				'user'     => 'root',
				'database' => 'teacher',
				'password' => '234679',
				'charset'  => 'utf8'
			]
		],
		'write' => [
			'host'     => '127.0.0.1',
			'user'     => 'root',
			'database' => 'teacher',
			'password' => '234679',
			'charset'  => 'utf8'
		]
	],
	'redis' => [
		[
			'host' => '127.0.0.1',
			'port' => 6379
		],
	],
	'redisSession' => [
		[
			'host' => '127.0.0.1',
			'port' => 6379,
			'main' => true,
		],[
			'host' => '127.0.0.1',
			'port' => 6380,
			'main' => false,
		],[
			'host' => '127.0.0.1',
			'port' => 6381,
			'main' => false
		],
	],
	'flashText' => [
		'cssStart'  => '<div class="alert alert-%s">',
		'cssEnd'    => '</div>',
		'isBigText' => true,
	]
];