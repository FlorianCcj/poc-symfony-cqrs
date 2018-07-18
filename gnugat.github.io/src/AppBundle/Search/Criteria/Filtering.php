<?php
// File: src/AppBundle/Search/Filtering.php;
// Source: https://gnugat.github.io/2016/05/18/towards-cqrs-search-engine.html
// Phase: P2

namespace AppBundle\Search\Criteria;

class Filtering
{
    public $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public static function fromQueryParameters(array $queryParameters) : self
    {
        $fields = $queryParameters;
        unset($fields['page']);
        unset($fields['per_page']);
        unset($fields['sort']);

        return new self($fields);
    }
}