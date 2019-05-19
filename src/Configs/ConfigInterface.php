<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21.04.2018
 * Time: 19:15
 */

namespace ES\Kernel\Configs;

interface ConfigInterface
{
	/**
	 * @param string $config
	 * @param string $param
	 * @param string $default
	 * @return mixed
	 */
	public static function get(string $config, string $param = '', string $default = '');

	/**
	 * @return array
	 */
	public static function getExceptionHandlers(): array;

	/**
	 * @return array
	 */
	public static function getRouters(): array;

	/**
	 * @param string $env
	 */
	public static function setEnvForConfig(string $env): void;
}