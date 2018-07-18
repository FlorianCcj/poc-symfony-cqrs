<?php
// File: src/AppBundle/DoctrineSearch/Builder.php;
// Source: https://gnugat.github.io/2016/05/18/towards-cqrs-search-engine.html
// Phase: P2

namespace AppBundle\DoctrineSearch;

use AppBundle\Search\Criteria;
use Doctrine\DBAL\Query\QueryBuilder;

interface Builder
{
    public function supports(Criteria $criteria) : bool;
    public function build(Criteria $criteria, QueryBuilder $queryBuilder);
}