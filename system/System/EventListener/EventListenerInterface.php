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
	public function __construct(array $arguments = []);

	public function execute();
}