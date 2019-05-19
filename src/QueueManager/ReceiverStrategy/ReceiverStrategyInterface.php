<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 24.04.2018
 * Time: 14:46
 */

namespace ES\Kernel\QueueManager\ReceiverStrategy;

use ES\Kernel\QueueManager\QueueModelInterface;

interface ReceiverStrategyInterface
{
	/**
	 * @param QueueModelInterface $params
	 * @return ReceiverStrategyInterface
	 */
	public function setParams(QueueModelInterface $params): ReceiverStrategyInterface;

    /**
     * @return mixed
     */
    public function build();

    /**
     * @return array
     */
	public function getCreatedObject(): array;

}