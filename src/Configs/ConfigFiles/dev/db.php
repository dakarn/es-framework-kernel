<?php

use ES\Kernel\System\Database\Schema\MySQL\{TeacherTables, ESFrameworkTables};
use ES\Kernel\System\Database\DB;

return [
	DB::MYSQL => [
		TeacherTables::TEACHER => [
			'oneInstance' => [
				'host'     => '127.0.0.1',
				'user'     => 'root',
				'password' => '234679',
				'charset'  => 'utf8'
			]
		],
		ESFrameworkTables::ES_FRAMEWORK => [
			'oneInstance' => [
				'host'     => '127.0.0.1',
				'user'     => 'root',
				'password' => '234679',
				'charset'  => 'utf8'
			]
		],
	],
	DB::PGSQL => [
		TeacherTables::TEACHER => [
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