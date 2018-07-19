<?php
// CommandBusDispatcher.php

class CommandBusDispatcher implements CommandBusMiddleWare
{
	public function __construct(iterable $handlers)
	{
		foreach ($handlers as $handler) {
			$this->handlers[$handler->listenTo()] = $handler;
		}
	}

	public function dispatch(Command $command): CommandResponse
	{
		$commandClass = get_class($command);
		$handler = $this->handlers[$commandClass];
		if($handler == null) {
			throw new \LogicExecption("Handler for command $commandClass not found");
			return $handler->handle($command);
		}
	}
}
