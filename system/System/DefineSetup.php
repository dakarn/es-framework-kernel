<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.03.2018
 * Time: 2:17
 */

define('PATH_SYSTEM', \dirname(\dirname(__DIR__)) . '/system/');

if (!defined('PATH_APP')) {
	define('PATH_APP', '');
}

if (!defined('TEMPLATE')) {
	define('TEMPLATE', '');
}

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