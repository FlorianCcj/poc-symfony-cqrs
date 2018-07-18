<?php
// File: src/AppBundle/DoctrineSearch/DoctrineResult.php;
// Source: https://gnugat.github.io/2016/05/18/towards-cqrs-search-engine.html
// Phase: P2

namespace AppBundle\DoctrineSearch;

use Doctrine\DBAL\Query\QueryBuilder;
use Porpaginas\Result;

class DoctrineResult implements Result
{
    private $queryBuilder;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function take($offset, $limit)
    {
        $queryBuilder = clone $this->queryBuilder;
        $queryBuilder->setFirstResult($offset);
        $queryBuilder->setMaxResults($limit);
        $statement = $queryBuilder->execute();

        return new IteratorPage($statement->getIterator(), $offset, $limit, $this->count());
    }

    public function count()
    {
        $queryBuilder = clone $this->queryBuilder;
        $subSql = $queryBuilder->getSql();
        $sql = <<<SQL
SELECT count(*) AS count
FROM (
    $subSql
) as sub_query
SQL
        ;
        $result = $queryBuilder->getConnection()->fetchAssoc($sql, $queryBuilder->getParameters());

        return $result['count'] ?? 0;
    }

    public function getIterator()
    {
        $queryBuilder = clone $this->queryBuilder;
        $statement = $queryBuilder->execute();

        return $statement->getIterator();
    }
}
