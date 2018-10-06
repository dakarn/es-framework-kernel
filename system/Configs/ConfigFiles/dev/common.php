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
	'User' => 'User',
	'redis' => [
		[
			'host' => '127.0.0.1',
			'port' => 6379
		],
	],
	'redisSession' => [
		[
			'host'      => '127.0.0.1',
			'port'      => 6379,
			'important' => 0
		],[
			'host'      => '127.0.0.1',
			'port'      => 6380,
			'important' => 1
		],[
			'host'      => '127.0.0.1',
			'port'      => 6381,
			'important' => 2
		],[
			'host'      => '127.0.0.1',
			'port'      => 6382,
			'important' => 3
		],
	],
	'flashText' => [
		'cssStart'  => '<div class="alert alert-%s">',
		'cssEnd'    => '</div>',
		'isBigText' => true,
	]
];