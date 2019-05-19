<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.04.2018
 * Time: 15:53
 */

namespace ES\Kernel\RedisQueue;

interface OutputResultInterface
{
    /**
     * OutputResultInterface constructor.
     * @param Server $redisQueue
     */
	public function __construct(Server $redisQueue);

	/**
	 * @return mixed
	 */
	public function done();

	/**
	 * @param string $typeRequeue
	 * @return mixed
	 */
	public function failed(string $typeRequeue);
}