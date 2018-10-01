<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.10.2018
 * Time: 0:15
 */

namespace System\Database\ORM;


class StoreModelORM
{
	/**
	 * @var array
	 */
	private static $models = [];

	public static function getModel()
	{

	}

	public static function saveModel($className, $objectORM)
	{
		self::$models[$className] = $objectORM;
	}
}