// LoggerMiddleware.php

/**
 * Middleware to log how long is during each command
 */
class LoggerMiddleware implements CommandBusMiddleware
{
	/**
	 * $next next middleware, can be the dispatcher
	 * $logger collaborator
	 *
	 */
	function __construct(
		CommandBusMiddleware $next,
		LoggerInterface $logger
	)
	{
		$this->next = $nexy;
		$this->logger = $logger;
	}

	function dispatch(Command $command): CommandResponse
	{
		$startTime = microtime(true);
		$response = $this->next->dispatch($command);
		$endtime = microtime(true);
		$elapsed = $endTime - $startTime;

		$message = 'Command '.get_class($command).' took: '.$elapsed;

		return response;
	}
}