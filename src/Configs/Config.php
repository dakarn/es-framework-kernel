<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.03.2018
 * Time: 21:18
 */

namespace ES\Kernel\Configs;

use ES\Kernel\Exception\FileException;

class Config implements ConfigInterface
{
    /**
     * @var string
     */
	public const EXTENSION_CONFIG = '.php';

    /**
     * @var string
     */
	public const DIR_ROUTERS = 'routers/';

	/**
	 * @var string
	 */
	public const DIR_CONFIGS_APP = 'Configs/';


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
	 * @throws FileException
	 */
	public static function getExceptionHandlers(): array
	{
		return self::get('exception-handlers');
	}

	/**
	 * @return array
	 * @throws FileException
	 */
	public static function getRouters(): array
	{
		if (isset(self::$bufferConfigFiles['routers'])) {
			return self::$bufferConfigFiles['routers'];
		}
		
		$routersCustom = self::get('common', 'routerFiles')['customRoutersApp'];
		$routers       = self::getConfigFromApp($routersCustom . self::EXTENSION_CONFIG);
		$item          = [];

		foreach ($routers as $router) {
			$path = PATH_APP . self::DIR_CONFIGS_APP . self::DIR_ROUTERS . $router . self::EXTENSION_CONFIG;

			if (!\is_file($path)) {
				continue;
			}

			$item = \array_merge($item, include_once($path));
		}

		self::$bufferConfigFiles['routers'] = $item;
		return $item;
	}

	/**
	 * @param string $env
	 */
	public static function setEnvForConfig(string $env): void
    {
        self::$currEnv = \strtolower($env);
    }

	/**
	 * @param string $config
	 * @return mixed
	 */
    private static function getConfigFromApp(string $config)
    {
	    $configData = include_once(PATH_APP . self::DIR_CONFIGS_APP . self::DIR_ROUTERS . $config);

	    return $configData;
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

        if (\is_file($pathConfigEnv)) {
            return $pathConfigEnv;
        } else if (\is_file($pathConfig)) {
            return $pathConfig;
        }

        throw FileException::notFound([$pathConfigEnv]);
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