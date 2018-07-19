<?php
// BasketEventApplier.php

trait BasketEventApplier
{
	private function productAdded(ProductAdded $event)
	{
		$instance = $this->createInstance($this);
		$instance->products[] = new BasketProduct($event);
		return $instance;
	}

	public function apply($event) 
	{
		$applier = $this->eventMap[get_class($event)];
		return $this->applier($event);
	}

	private $eventMap = [
		ProductAdded::class => 'productAdded'
	];
}
