<?php
// DoctrineFlushBusMiddleware.php

class DoctrineFlushBusMiddleware
{
	function __construct(
		CommandBus $next,
		EntityManagerInterface $entityManager
	)
	{
		$this->next = $next;
		$this->entityManager = $entityManager;
	}

	function dispatch(Command $command): CommandResponse
	{
		$this->entityManager->getConnection()->beginTransaction();
		try {
			$commandResponse = $this->next->dispatch($command);
			$this->entityManager->flush();
			$this->entityManager->getConnection()->commit();
		} catch (\Exception $e) {
			$this->entityManager->getConnection()->rollBack();
		}
		return $commandResponse;
	}
}
