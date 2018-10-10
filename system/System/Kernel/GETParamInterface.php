<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.10.2018
 * Time: 19:13
 */

namespace System\Kernel;

interface GETParamInterface
{
	/**
	 * @param array $nameParams
	 * @param array $values
	 */
	public static function setParamForController(array $nameParams, array $values): void;

	/**
	 * @return array
	 */
	public static function getParamForController(): array;

	/**
	 * @return string
	 */
	public static function getPath(): string;

	/**
	 * @param string $param
	 * @param string $value
	 */
	public static function addGET(string $param, string $value): void;

	/**
	 * @return string
	 */
	public static function options(): string;
}