<?php
// EventDispatcherBusMiddleware.php

class EventDispatcherBusMiddleware implements CommandBusMiddleware
{
	function __construct(CommandBus $next, EventBus $eventBus)
	{
		$this->bus = bus;
		$this->eventBus = $eventBus;
	}

	public function dispatch(Command $command): CommandResponse
	{
		$commandResponse = $this->bus->dispatch($command);

		if($commandResponse->hasEvents()) {
			foreach ($commandResponse->events() as $event) {
				$this->eventBus->dispatch($event);
			}
		}
		return $commandResponse;
	}
}
