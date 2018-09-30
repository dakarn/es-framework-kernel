<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.03.2018
 * Time: 2:17
 */

define('PATH_APP', \dirname(\dirname(\dirname(\dirname(__DIR__)))) . '/app/');
define('TEMPLATE', PATH_APP . 'Templates');
define('PATH_LOADER', __DIR__ . '/vendor/autoload.php');
define('PATH_SYSTEM', \dirname(\dirname(\dirname(\dirname(__DIR__)))) . '/vendor/es-framework-kernel/system/');

if (isset($_SERVER['HTTP_HOST'])) {
	define('IS_DOMAIN', true);

	if (IS_DOMAIN) {
		define('URL', 'http://' . $_SERVER['HTTP_HOST'].'/');
	} else {
		define('URL', 'http://' . $_SERVER['HTTP_HOST'] .'/elasticsearch/');
	}
}

if (!defined('IS_WEB')) {
	define('IS_WEB', false);
}

define('CONFIG_PATH', PATH_SYSTEM . 'Configs/ConfigFiles/');
define('APP_EVENT', PATH_APP . 'AppEvent.php');
define('APP_KERNEL', PATH_APP . 'AppKernel.php');
define('IS_CLI', PHP_SAPI === 'cli');
define('IS_API', false);