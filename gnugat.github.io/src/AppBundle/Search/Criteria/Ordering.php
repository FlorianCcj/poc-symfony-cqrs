<?php
// File: src/AppBundle/Search/Ordering.php;
// Source: https://gnugat.github.io/2016/05/18/towards-cqrs-search-engine.html
// Phase: P2

namespace AppBundle\Search\Criteria;

class Ordering
{
    const DEFAULT_FIELD = 'name';
    const DEFAULT_DIRECTION = 'ASC';

    public $field;
    public $direction;

    public function __construct(string $field, string $direction)
    {
        $this->field = $field;
        $this->direction = $direction;
    }

    public static function fromQueryParameters(array $queryParameters) : self
    {
        $column = $queryParameters['sort'] ?? self::DEFAULT_FIELD;
        $direction = self::DEFAULT_DIRECTION;
        if ('-' === $column[0]) {
            $direction = 'DESC';
            $column = trim($column, '-');
        }

        return new self($column, $direction);
    }
}
