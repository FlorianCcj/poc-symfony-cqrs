<?php
// File: src/AppBundle/Profile/CreateNewProfileHandler.php;
// Source: https://gnugat.github.io/2016/05/11/towards-cqrs-command-bus.html
// Phase: P1

namespace AppBundle\Profile;

use AppBundle\Entity\Profile;
use Doctrine\ORM\EntityManager;

class CreateNewProfileHandler
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(CreateNewProfile $createNewProfile)
    {
        if (null !== $this->entityManager->getRepository('AppBundle:Profile')->findOneByName($createNewProfile->name)) {
            throw new \DomainException("Invalid \"name\" parameter: \"$name\" already exists and duplicates are not allowed");
        }
        $createdProfile = new Profile($name);
        $em->persist($createdProfile);
        $em->flush();

        return $createdProfile;
    }
}
