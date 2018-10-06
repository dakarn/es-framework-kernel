<?php

use Http\Request\ServerRequest;
use Http\Cookie;
use Http\Session\SessionRedis;
use System\Registry;
use System\Kernel\TypesApp\AbstractApplication;
use App\Model\User\User;

/** @var AbstractApplication $app */
$app =  Registry::get(Registry::APP);

return [
	'request' => ServerRequest::create(),
	'cookie'  => Cookie::create(),
	'session' => SessionRedis::create(),
	'env'     => $app->getEnvironment(),
	'user'    => User::current()
];