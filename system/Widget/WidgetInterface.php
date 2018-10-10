<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.04.2018
 * Time: 15:58
 */

namespace Widget;

interface WidgetInterface
{
	/**
	 * WidgetInterface constructor.
	 */
	public function __construct();

	/**
	 * @return mixed
	 */
	public function run();
}