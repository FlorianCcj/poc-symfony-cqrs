vrac.php

using it (test)
==========

$repository = new SubscriptionPlanInMemoryRepository();

$handler = new CreateSubscriptionPlanCommandHandler($repository);
$response = $handler->handle(
	new CreateSubscriptionPlanCommand(
		'label', 12, 20, '2018-10-02', ['gym', 'tennis']
	);
);

$response->value();
