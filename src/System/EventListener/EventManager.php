<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.03.2018
 * Time: 1:04
 */

namespace ES\Kernel\System\EventListener;

class EventManager implements EventManagerInterface
{
	/**
	 * @var array
	 */
	private $events = [];

	/**
	 * @param string $event
	 * @param $className
	 * @return EventManager
	 */
	public function addEventListener(string $event, $className): self
	{
		$this->events[$event] = $className;
		return $this;
	}

	/**
	 * @param string $event
	 * @return bool
	 */
	public function hasEventListener(string $event): bool
	{
		return isset($this->events[$event]);
	}

    /**
     * @param string $event
     * @param EventListenerInterface $newClass
     */
	public function replaceEventListener(string $event, EventListenerInterface $newClass)
	{
		if (isset($this->events[$event])) {
			$this->events[$event] = $newClass;
		}
	}

	/**
	 * @return array
	 */
	public function getEvents(): array
	{
		return $this->events;
	}

	/**
	 * @param string $typeEvent
	 * @return array
	 */
	public function getEventsByType(string $typeEvent): array
	{
		return $this->events[$typeEvent] ?? [];
	}

	/**
	 * @param string $event
	 */
	public function removeEventListener(string $event): void
	{
		unset($this->events[$event]);
	}

	/**
	 * @param string $event
	 * @param array $arguments
	 */
	public function runEvent(string $event, array $arguments = []): void
	{
		/** @var $classInstance EventListenerInterface */
		if ($this->hasEventListener($event)) {

			$className     = $this->events[$event];
			$classInstance = new $className($arguments);
			$classInstance->execute();
		}
	}
}