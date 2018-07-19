<?php
// PlansResource.php

/**
 * Class PaymentResource
 * @Route("/plans")
 */
class PlansResource
{
	public function __construct(
		CommandBus $commandBus,
		SerializeInterface $serializer
	)
	{
		$this->commandBus = $commandBus;
		$this->serializer = $serializer;
	}

	/**
	 * @Route("/", method={POST})
	 */
	public function create(Request $request)
	{
		$command = $this->serializer->deserialize(
			$request->getContent(),
			CreateSubscriptionPlanCommand::class,
			'json'
		);

		$response = $this->commandBus->dispatch($command);

		return Response::create($response->value(), 201);
	}
}