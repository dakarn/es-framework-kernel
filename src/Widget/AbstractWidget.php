<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.04.2018
 * Time: 15:47
 */

namespace Widget;

abstract class AbstractWidget implements WidgetInterface
{
	public function __construct()
	{
		echo $this->run();
	}

	abstract public function run(): string;
}