<?php
// BasketRepository.php

class BasketRepository
{
	public function get(Uuid $id)
	{
		$events = $this->getEventsByAggregate($id);
		$instance = new Basket();
		foreach($events as $event) {
			[$instance, $void] = $instance->apply($events);
		}
		return $instance;
	}

	private function getEventsByAggregate(Uuid $id)
	{
		$stmt = $this->connection->prepare("
			SELECT payload
			FROM events
			WHERE aggregate_type = 'BASKET'
			AND aggregate_id = :id
			ORDER BY timestamp
		");
		$stmt->execute(['id' => $id->toString()]);
		$result = $stmt->fetchAll(FetchMode::COLUMN);

		return array_map(function($result) {
			unserialize($result['payload']);
		}, $results);
	}
}