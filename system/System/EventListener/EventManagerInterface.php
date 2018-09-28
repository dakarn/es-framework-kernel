<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.03.2018
 * Time: 19:10
 */

namespace System\EventListener;

interface EventManagerInterface
{
	/**
	 * @param string $event
	 * @param $className
	 * @return EventManager
	 */
	public function addEventListener(string $event, $className): EventManager;

	/**
	 * @param string $event
	 * @return bool
	 */
	public function hasEventListener(string $event): bool;

    /**
     * @param string $event
     * @param EventListenerInterface $newClass
     */
	public function replaceEventListener(string $event, EventListenerInterface $newClass);

	/**
	 * @param string $event
	 * @return mixed
	 */
	public function removeEventListener(string $event);

	/**
	 * @param string $event
	 * @param array $arguments
	 * @return mixed
	 */
	public function runEvent(string $event, array $arguments = []);
}