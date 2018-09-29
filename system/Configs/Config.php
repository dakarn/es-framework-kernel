<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.03.2018
 * Time: 21:18
 */

namespace Configs;

use Exception\FileException;
use System\Kernel\TypesApp\AbstractApplication;

class Config implements ConfigInterface
{
    /**
     * @var string
     */
	const EXTENSION_CONFIG = '.php';

    /**
     * @var string
     */
	const DIR_ROUTERS = 'routers/';

    /**
     * @var string
     */
	private static $currEnv = '';

    /**
     * @var array
     */
	private static $bufferConfigFiles = [];

    /**
     * @param string $config
     * @param string $param
     * @param string $default
     * @return mixed|string
     * @throws FileException
     */
	public static function get(string $config, string $param = '', string $default = '')
	{
		if (isset(self::$bufferConfigFiles[$config])) {
			if (!empty($param)) {
				return self::getByParam(self::$bufferConfigFiles[$config], $param, $default);
			}

			return self::$bufferConfigFiles[$config];
		}

        $configData = include_once(self::searchConfig($config));
        self::$bufferConfigFiles[$config] = $configData;

        if (!empty($param)) {
            return self::getByParam($configData, $param, $default);
        }

        return $configData;

	}

	/**
	 * @return array
	 */
	public static function getExceptionHandlers(): array
	{
		return self::get('exception-handlers');
	}

    /**
     * @return array
     */
	public static function getRouters(): array
	{
		if (isset(self::$bufferConfigFiles['routers'])) {
			return self::$bufferConfigFiles['routers'];
		}

		$routers = self::get('common', 'routerFiles');
		$item    = [];

		foreach ($routers as $router) {
			$item = array_merge($item, include_once(CONFIG_PATH . self::DIR_ROUTERS . $router . self::EXTENSION_CONFIG));
		}

		self::$bufferConfigFiles['routers'] = $item;
		return $item;
	}

	/**
	 * @param AbstractApplication $application
	 */
	public static function setEnvForConfig(AbstractApplication $application): void
    {
        self::$currEnv = strtolower($application->getEnvironment());
    }

    /**
     * @param string $config
     * @return string
     * @throws FileException
     */
    private static function searchConfig(string $config): string
    {
        $pathConfigEnv = CONFIG_PATH . self::$currEnv . '/' . $config . self::EXTENSION_CONFIG;
        $pathConfig    = CONFIG_PATH . $config . self::EXTENSION_CONFIG;

        if (is_file($pathConfigEnv)) {
            return $pathConfigEnv;
        } else if (is_file($pathConfig)) {
            return $pathConfig;
        }

        throw FileException::notFound([$config]);
    }

    /**
     * @param array $config
     * @param string $param
     * @param string $default
     * @return mixed|string
     */
	private static function getByParam(array $config, string $param, string $default)
	{
		if (isset($config[$param])) {
			return $config[$param];
		}

		return $default;
	}
}