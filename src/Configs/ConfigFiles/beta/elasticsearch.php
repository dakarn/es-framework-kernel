<?php

return [
	'schema'  => 'http',
	'host'    => '127.0.0.1',
	'port'    => '9200',
	'mappings' => [
		'dictionary' => [
			'properties' => [
				'text' => [
					'type' => 'text'
				],
				'translate' => [
					'type' => 'text'
				],
				'type' => [
					'type' => 'integer'
				],
				'level' => [
					'type' => 'integer'
				],
				'audioFile' => [
					'type' => 'text'
				]
			]
		]
	],
];