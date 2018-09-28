<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.04.2018
 * Time: 14:28
 */

namespace Queue;

interface QueueSenderInterface
{
	public function build();

	public function __construct(Queue $queue, array $configConnect);
}