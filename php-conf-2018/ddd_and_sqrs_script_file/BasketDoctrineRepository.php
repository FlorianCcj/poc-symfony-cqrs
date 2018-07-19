<?php
// BasketDoctrineRepository.php

class BasketDoctrineRepository implements Repository
{
	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->doctrineEntityManager = $entityManager;
	}

	public function get(Uuid $uuid): Basket
	{
		$doctrineEntity = $this->doctrineEntityManager
			->getRepository(BasketDoctrineEntity::class)
			->find($uuid)
		;
		if($doctrineEntity == null) {
			throw new EntityNotFoundException();
		}
		return Basket::mapFromDoctrine($doctrineEntity);
	}

	public function add(Basket $entity): void
	{
		$this->doctrineEntityManager
			->merge(BasketDoctrineEntity::mapFromPayment($entity))
		;
	}
}