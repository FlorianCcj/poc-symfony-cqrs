<?php
// CommandBusFactory.php

class CommandBusFactory
{
	static function build(
		iterable $handler,
		Logger $logger
	): CommandBus
	{
		return new LoggerBusMiddleware(
			new CommandBusDispatcher($handler),
		$logger);
	}
}