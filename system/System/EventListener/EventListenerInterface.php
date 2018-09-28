<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.03.2018
 * Time: 1:28
 */

namespace System\EventListener;

interface EventListenerInterface
{
	/**
	 * EventListenerInterface constructor.
	 * @param array $arguments
	 */
	public function __construct(array $arguments = []);

	/**
	 * @return mixed
	 */
	public function execute();
}