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
		'read' => [
	        'host'     => '127.0.0.1',
	        'user'     => 'root',
	        'database' => 'teacher',
	        'password' => '234679',
	        'charset'  => 'utf8'
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
	        'host'     => '127.0.0.1',
	        'user'     => 'root',
	        'database' => 'teacher',
	        'password' => '234679',
	        'charset'  => 'utf8'
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
	        'host'     => '127.0.0.1',
	        'user'     => 'root',
	        'database' => 'teacher',
	        'password' => '234679',
	        'charset'  => 'utf8'
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
	        'host'     => '127.0.0.1',
	        'user'     => 'root',
	        'database' => 'teacher',
	        'password' => '234679',
	        'charset'  => 'utf8'
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
		'host' => '127.0.0.1',
	],
	'flashText' => [
		'cssStart'  => '<div class="alert alert-%s">',
		'cssEnd'    => '</div>',
		'isBigText' => true,
	]
];