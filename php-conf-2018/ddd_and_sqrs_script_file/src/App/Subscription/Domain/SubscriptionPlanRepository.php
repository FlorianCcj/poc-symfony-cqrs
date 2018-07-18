// src/App/Subscription/Domain/SubscriptionPlanRepository.php
namespace App\Subscription\Domain;

use App\Common\DDD\Repository;
use Ramsey\Uuid\Uuid;

// after remove query function, seems to be table interface
interface SubscriptionPlanRepository extends Repository
{
	public function get(Uuid $id): SubscriptionPlan;

	// P3 remove for event sourcing
	public function add(SubscriptionPlan $entity): void;
	
	// P3 remove for event sourcing
	public function delete(Uuid $id): void;
	
	// P2 remove when repository go to command only
	public function getAllPlan(): array;
	
	// P2 remove when repository go to command only
	public function findActivePlan(): array;
}
