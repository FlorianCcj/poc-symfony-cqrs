<?php
// File: src/AppBundle/Search/Criteria.php;
// Source: https://gnugat.github.io/2016/05/18/towards-cqrs-search-engine.html
// Phase: P2

namespace AppBundle\Search;

use AppBundle\Search\Criteria\Filtering;
use AppBundle\Search\Criteria\Ordering;
use AppBundle\Search\Criteria\Paginating;

class Criteria
{
    public $resourceName;
    public $filtering;
    public $ordering;
    public $paginating;

    public function __construct(
        string $resourceName,
        Filtering $filtering,
        Ordering $ordering,
        Paginating $paginating
    ) {
        $this->resourceName = $resourceName;
        $this->filtering = $filtering;
        $this->ordering = $ordering;
        $this->paginating = $paginating;
    }

    public static function fromQueryParameters(string $resourceName, array $queryParameters) : self
    {
        return new self(
            $resourceName,
            Filtering::fromQueryParameters($queryParameters),
            Ordering::fromQueryParameters($queryParameters),
            Paginating::fromQueryParameters($queryParameters)
        );
    }
}