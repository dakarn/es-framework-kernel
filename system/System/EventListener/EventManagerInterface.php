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
	public function addEventListener(string $event, $className): EventManager;

	public function hasEventListener(string $event): bool;

	public function replaceEventListener(string $event, EventListenerInterface $newClass);

	public function removeEventListener(string $event);

	public function runEvent(string $event, array $arguments = []);
}