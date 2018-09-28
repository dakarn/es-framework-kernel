<?php

$applicationInstance = new \System\Kernel\TypesApp\WebApp();
$applicationInstance->setApplicationType('Web');

$appKernel
	->installMiddlewares()
	->installProviders();

$request = \Http\Request\Request::create();
$request->handle($appKernel);