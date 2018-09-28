<?php

namespace System\Kernel;

use Http\Request\Request;

class GETParam
{
	private static $paramForController = [];

	public static function setParamForController(array $nameParams, array $values): void
	{
		array_shift($values);

		foreach ($values as $index => $value) {
			self::$paramForController[$nameParams[$index]] = $value;
			self::addGET($nameParams[$index], $value);
		}
	}

	public static function getParamForController(): array
	{
		return self::$paramForController;
	}

	public static function getPath(): string
	{
		return str_replace(basename(__DIR__), '', self::options());
	}

	public static function addGET(string $param, string $value): void
	{
		$_GET[$param] = $value;
	}

	public static function options(): string
	{
		$options = Request::create()->takeGet('options');

		if (empty($options)) {
			self::addGET('options', '');
		}

		return $options;
	}
}