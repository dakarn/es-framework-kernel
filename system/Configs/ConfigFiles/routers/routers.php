<?php

use App\MiddlewareApp\MiddlewareCheckAuth;

return [
	[
		'name'       => 'search',
		'path'       => 'search-word',
		'controller' => 'Controller:IndexController',
		'action'     => 'searchWord',
		'allow'      => ['POST', 'GET'],
	],
	[
		'name'       => 'addIndex',
		'path'       => 'addIndex',
		'controller' => 'Controller:ElasticController',
		'action'     => 'addIndex',
		'middleware' => [MiddlewareCheckAuth::class],
		'allow'      => ['GET', 'POST'],
		'enterData'  => []
	],
	[
		'name'       => 'removeIndex',
		'path'       => 'removeIndex',
		'controller' => 'Controller:ElasticController',
		'action'     => 'removeIndex',
		'allow'      => ['GET'],
	],
	[
		'name'       => 'indexer',
		'path'       => 'indexer/{id}/{red}',
		'controller' => 'Controller:ElasticController',
		'action'     => 'indexer',
		'allow'      => ['GET'],
		'regex'      => true,
		'param'      => [
			'id'  => '\d+',
			'red' => '\d+',
		],
	],
	[
		'name'       => 'enterCommand',
		'path'       => 'enterCommand',
		'controller' => 'Controller:ElasticController',
		'action'     => 'enterCommand',
		'allow'      => ['GET'],
	],
	[
		'name'       => 'randomWord',
		'path'       => 'random-word/{id}',
		'controller' => 'Controller:IndexController',
		'action'     => 'dictionary',
		'allow'      => ['GET', 'POST', 'PUT'],
		'regex'      => true,
		'middleware' => [MiddlewareCheckAuth::class],
		'param'      => [
			'id' => '\d{1,5}',
		],
	],
];