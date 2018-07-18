// src/App/Subscription/Command/CreateSubscriptionPlanCommand.php
namescpace App\Subscription\Command;

class CreateSubscriptionPlanCommand implements Command
{
	public $price;
	public $name;
	public $annualDiscount;
	public $expirationDate;
	public $includedActivities;

	public function __construct($price, $name, $annualDiscount, $expirationDate, $includedActivities)
	{
		$this->price = $price;
		$this->name = $name;
		$this->annualDiscount = $annualDiscount;
		$this->expirationDate = $expirationDate;
		$this->includedActivities = $includedActivities;
	}
}
