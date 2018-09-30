<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 18:29
 */

namespace Http\Session;

use Traits\SingletonTrait;

class Session
{
	use SingletonTrait;

	private $strategy;

	public function getStrategy(): SessionStrategy
	{
		if (!$this->strategy instanceof SessionStrategy) {
			$this->strategy = new RedisStrategy();
		}

		return $this->strategy;
	}
}