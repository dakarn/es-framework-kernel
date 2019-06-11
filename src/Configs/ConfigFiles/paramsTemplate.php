<?php

use ES\Kernel\Http\Request\ServerRequest;
use ES\Kernel\Http\Cookie;
use ES\Kernel\Http\Session\SessionRedis;
use ES\Kernel\System\ES;
use ES\Kernel\Kernel\TypesApp\AbstractApplication;
use ES\Kernel\Models\User\User;

/** @var AbstractApplication $app */
$app =  ES::get(ES::APP);

return [
	'request' => ServerRequest::create(),
	'cookie'  => Cookie::create(),
	'session' => SessionRedis::create(),
	'env'     => $app->getEnvironment(),
	'user'    => User::current()
];