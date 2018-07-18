// AddProductToBasketCommandHandler.php
class AddProductToBasketCommandHandler implements CommandHandler
{
	public function handle(Command $command): CommandResponse
	{
		$basket = $this->repository->get($command->basketId);
		[$instance, $events] = $basket->addProduct($command->product);
		return CommandResponce::withValue($instance->id(), $events);
	}
}