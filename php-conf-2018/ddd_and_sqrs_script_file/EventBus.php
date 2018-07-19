<?php
// EventBus.php

class EventBus implements \App\Common\DDD\EventBus
{
	public function __construct(iterable $handlers) {
		foreach ($handlers as $handler) {
			$this->handlers[] = $handler;
		}
	}

	public function dispatch (Event $event): void
	{
		$eventClass = get_class($event);
		$matchingHandlers = array_filter(
			$this->handlers,
			function($handlers) use ($eventClass) {
				return $handler->listenTo() === $eventClass;
			} 
		);
		foreach ($matchongHandlers as $handler) {
			$handler->handle($event);
		}
	}
}
