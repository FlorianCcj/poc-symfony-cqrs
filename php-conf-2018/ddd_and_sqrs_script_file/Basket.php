<?php
// Basket.php

class Basket implements AggregateRoot
{
	use BasketEventApplier;

	public function addProduct(Product $product)
	{
		$event = new ProductAdded($product);
		return [
			$this->apply($event),
			$event
		];
	}
}
