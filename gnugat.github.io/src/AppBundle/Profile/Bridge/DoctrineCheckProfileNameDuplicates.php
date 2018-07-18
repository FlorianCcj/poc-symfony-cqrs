<?php
// File: src/AppBundle/Profile/Bridge/DoctrineCheckProfileNameDuplicates.php
// Source: https://gnugat.github.io/2016/05/11/towards-cqrs-command-bus.html
// Phase: P1

namespace AppBundle\Profile\Bridge;

use AppBundle\Profile\Service\CheckProfileNameDuplicates;
use Doctrine\ORM\EntityManager;

class DoctrineCheckProfileNameDuplicates implements CheckProfileNameDuplicates
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function check($name)
    {
        return null === $this
          ->entityManager
          ->getRepository('AppBundle:Profile')
          ->findOneByName($name);
    }
}
