<?php

return [
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
			'database' => 'es-framework',
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
];