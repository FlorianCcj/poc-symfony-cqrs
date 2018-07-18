<?php
// File: src/AppBundle/DoctrineSearch/DoctrineSearchEngine.php;
// Source: https://gnugat.github.io/2016/05/18/towards-cqrs-search-engine.html
// Phase: P2

namespace AppBundle\DoctrineSearch;

use AppBundle\Search\Criteria;
use AppBundle\Search\SearchEngine;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Porpaginas\Result;
use AppBundle\DoctrineSearch\DoctrineResult;

class DoctrineSearchEngine implements SearchEngine
{
    private $connection;
    private $builders = [];

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function add(Builder $builder)
    {
        $this->builders[] = $builder;
    }

    public function match(Criteria $criteria) : Result
    {
        $queryBuilder = new QueryBuilder($this->connection);
        foreach ($this->builders as $builder) {
            if (true === $builder->supports($criteria)) {
                $builder->build($criteria, $queryBuilder);
            }
        }

        return new DoctrineResult($queryBuilder);
    }
}
