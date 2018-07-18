// src/App/Subscription/Command/CreateSubscriptionPlanCommandHandler.php
namespace App\Subscription\Command;

class CreateSubscriptionPlanCommandHandler implements CommandHandler
{
	function __construct(SubscriptionPlanRepository $repository) {
		$this-repository = $repository;
	}

	function handle(CreateSubscriptionPlanCommand $command) {
		// here SubscriptionPlan is an aggregate root
		$subscription = new SubscriptionPlan(
			$command->name,
			Money::Euro($command->price),
			new DateTime($command->expirationDate), 
			$command->includedActivities
		);
		$this->repository->add($subscription);
		return CommandResponce::withValue($subscription->id());
	}

	function listenTo(): string {
		return CreateSubscriptionPlanCommand::class;
	}
}