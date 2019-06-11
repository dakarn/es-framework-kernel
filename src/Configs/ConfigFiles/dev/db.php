<?php

use ES\Kernel\Database\Schema\MySQL\{TeacherTables, ESFrameworkTables};
use ES\Kernel\Database\DB;
use ES\Kernel\Database\Schema\MySQL\MySQLDatabases;

return [
	DB::MYSQL => [
		MySQLDatabases::TEACHER => [
			'oneInstance' => [
				'host'     => '127.0.0.1',
				'user'     => 'root',
				'password' => '234679',
				'charset'  => 'utf8'
			]
		],
		MySQLDatabases::ES_FRAMEWORK => [
			'oneInstance' => [
				'host'     => '127.0.0.1',
				'user'     => 'root',
				'password' => '234679',
				'charset'  => 'utf8'
			]
		],
	],
	DB::PGSQL => [
		MySQLDatabases::TEACHER => [
			'read' => [
				[
					'host'     => '127.0.0.1',
					'user'     => 'root',
					'password' => '234679',
					'charset'  => 'utf8'
				]
			],
			'write' => [
				'host'     => '127.0.0.1',
				'user'     => 'root',
				'password' => '234679',
				'charset'  => 'utf8'
			]
		]
	],
];