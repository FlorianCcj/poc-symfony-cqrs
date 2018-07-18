<?php
// File: src/AppBundle/Profile/DoctrineSearch/ProfileNameFilteringBuilder.php;
// Source: https://gnugat.github.io/2016/05/18/towards-cqrs-search-engine.html
// Phase: P2

namespace AppBundle\Profile\DoctrineSearch;

use AppBundle\DoctrineSearch\Builder;
use AppBundle\Search\Criteria;
use Doctrine\DBAL\Query\QueryBuilder;

class ProfileNameFilteringBuilder implements Builder
{
    public function supports(Criteria $criteria) : bool
    {
        return 'profile' === $criteria->resourceName && isset($criteria->filtering->fields['name']);
    }

    public function build(Criteria $criteria, QueryBuilder $queryBuilder)
    {
        $queryBuilder->where('p.name LIKE :name');
        $queryBuilder->setParameter('name', "%{$criteria->filtering->fields['name']}");
    }
}
