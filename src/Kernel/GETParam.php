<?php

namespace ES\Kernel\Kernel;

class GETParam implements GETParamInterface
{
    /**
     * @var array
     */
	private static $paramForController = [];

    /**
     * @param array $nameParams
     * @param array $values
     */
	public static function setParamForController(array $nameParams, array $values): void
	{
		\array_shift($values);

		foreach ($values as $index => $value) {
			self::$paramForController[$nameParams[$index]] = $value;
			self::addGET($nameParams[$index], $value);
		}
	}

    /**
     * @return array
     */
	public static function getParamForController(): array
	{
		return self::$paramForController;
	}

    /**
     * @return string
     */
	public static function getPath(): string
	{
		return \str_replace(\basename(__DIR__), '', self::options());
	}

    /**
     * @param string $param
     * @param string $value
     */
	public static function addGET(string $param, string $value): void
	{
		$_GET[$param] = $value;
	}

    /**
     * @return string
     */
	public static function options(): string
	{
		$options = !empty($_GET['options']) ? $_GET['options'] : '';

		if (empty($options)) {
			self::addGET('options', '');
		}

		return $options;
	}
}