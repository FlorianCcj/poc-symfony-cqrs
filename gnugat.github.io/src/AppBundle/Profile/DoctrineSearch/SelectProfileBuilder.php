<?php
// File: src/AppBundle/Profile/DoctrineSearch/SelectProfileBuilder.php;
// Source: https://gnugat.github.io/2016/05/18/towards-cqrs-search-engine.html
// Phase: P2

namespace AppBundle\Profile\DoctrineSearch;

use AppBundle\DoctrineSearch\Builder;
use AppBundle\Search\Criteria;
use Doctrine\DBAL\Query\QueryBuilder;

class SelectProfileBuilder implements Builder
{
    public function supports(Criteria $criteria) : bool
    {
        return 'profile' === $criteria->resourceName;
    }

    public function build(Criteria $criteria, QueryBuilder $queryBuilder)
    {
        $queryBuilder->select('name');
        $queryBuilder->from('profile', 'p');
    }
}