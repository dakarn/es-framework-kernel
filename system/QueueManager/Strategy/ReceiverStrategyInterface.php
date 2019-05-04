<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 24.04.2018
 * Time: 14:46
 */

namespace QueueManager\Strategy;

use QueueManager\QueueModel;

interface ReceiverStrategyInterface
{
	/**
	 * @param QueueModel $params
	 * @return ReceiverStrategyInterface
	 */
	public function setParams(QueueModel $params): ReceiverStrategyInterface;

    /**
     * @return mixed
     */
    public function build();

	public function getCreationObject(): array;

}