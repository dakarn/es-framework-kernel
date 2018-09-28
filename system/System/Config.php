<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.03.2018
 * Time: 21:18
 */

namespace System;

use Exception\FileException;

class Config
{
	const EXTENSION_CONFIG = '.php';
	const DIR_ROUTERS      = 'routers/';

	private static $bufferConfigFiles = [];

	public static function get(string $config, string $param = '', string $default = '')
	{
		if (isset(self::$bufferConfigFiles[$config])) {
			if (!empty($param)) {
				return self::getByParam(self::$bufferConfigFiles[$config], $param, $default);
			}

			return self::$bufferConfigFiles[$config];
		}

		$pathConfig = CONFIG_APP_PATH . $config . self::EXTENSION_CONFIG;

		if (is_file($pathConfig)) {

			$configData = include_once($pathConfig);
			self::$bufferConfigFiles[$config] = $configData;

			if (!empty($param)) {
				return self::getByParam($configData, $param, $default);
			}

			return $configData;
		}

		throw FileException::notFound([$config]);
	}

	public static function getRouters(): array
	{
		if (isset(self::$bufferConfigFiles['routers'])) {
			return self::$bufferConfigFiles['routers'];
		}

		$routers = self::get('common', 'routerFiles');
		$item    = [];

		foreach ($routers as $router) {
			$item = array_merge($item, include_once(CONFIG_APP_PATH . self::DIR_ROUTERS . $router . self::EXTENSION_CONFIG));
		}

		self::$bufferConfigFiles['routers'] = $item;
		return $item;
	}

	private static function getByParam(array $config, string $param, string $default)
	{
		if (isset($config[$param])) {
			return $config[$param];
		}

		return $default;
	}
}