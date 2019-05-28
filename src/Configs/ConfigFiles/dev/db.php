<?php

use ES\Kernel\System\Database\Schema\MySQL\{TeacherDatabase, ESFrameworkDatabase};
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
		],
		ESFrameworkDatabase::ES_FRAMEWORK => [
			'oneInstance' => [
				'host'     => '127.0.0.1',
				'user'     => 'root',
				'password' => '234679',
				'charset'  => 'utf8'
			]
		],
	],
	DB::PGSQL => [
		TeacherDatabase::TEACHER => [
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