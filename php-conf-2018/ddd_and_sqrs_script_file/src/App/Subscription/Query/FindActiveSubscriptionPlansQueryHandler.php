// src/App/Subscription/Query/FindActiveSubscriptionPlansQueryHandler.php
namespace App\Subscription\Query;

class FindActiveSubscriptionPlansQueryHandler implements QueryHandler
{
	// function __construct(SubscriptionPlanRepository $repository) { // P1
	function __construct(EntityManager $connection) { //P2
		// $this-repository = $repository; // P1
		$this->connection = $connection; // P2
	}

	// function handle(FindActiveSubscriptionPlansQuery $query): SubscriptionPlanViewModel[] { // P1
	function handle(Query $query): array { //P2
		/* return array_map(function(subscriptionPlan $plan) {
			return SubscriptionPlanViewModel::fromEntity($plan);
		}, $this->repository-> findActivePlan());*/ //P1

		$query = $this->connection->createQuery("
			SELECT NEW SubscriptionViewModel(s.name, s.price)
			FROM Subscription s
		"); // P2
		return $query->getResult();
	}

	function listenTo(): string {
		return FindActiveSubscriptionPlansQuery::class;
	}
}