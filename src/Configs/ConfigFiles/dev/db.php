<?php

use ES\Kernel\System\Database\Schema\MySQL\TeacherDatabase;
use ES\Kernel\System\Database\DB;

return [
	DB::MYSQL => [
		TeacherDatabase::TEACHER => [
			'oneInstance' => [
				'host'     => '127.0.0.1',
				'user'     => 'root',
				'password' => '234679',
				'charset'  => 'utf8'
			]
		]
	],
	DB::PGSQL => [
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
	DB::ORACLE => [
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
	DB::MSSQL => [
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