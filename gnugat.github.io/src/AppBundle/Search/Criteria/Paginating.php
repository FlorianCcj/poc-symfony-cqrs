<?php
// File: src/AppBundle/Search/Criteria.php;
// Source: https://gnugat.github.io/2016/05/18/towards-cqrs-search-engine.html
// Phase: P2

namespace AppBundle\Search\Criteria;

class Paginating
{
    const DEFAULT_CURRENT_PAGE = 1;
    const DEFAULT_ITEMS_PER_PAGE = 10;

    public $currentPage;
    public $itemsPerPage;
    public $offset;

    public function __construct(int $currentPage, int $itemsPerPage)
    {
        $this->currentPage = $currentPage;
        if ($this->currentPage <= 0) {
            $this->currentPage = self::DEFAULT_CURRENT_PAGE;
        }
        $this->itemsPerPage = $itemsPerPage;
        if ($this->itemsPerPage <= 0) {
            $this->itemsPerPage = self::DEFAULT_ITEMS_PER_PAGE;
        }
        $this->offset = $this->currentPage * $this->itemsPerPage - $this->itemsPerPage;
    }

    public static function fromQueryParameters(array $queryParameters) : self
    {
        $currentPage = $queryParameters['page'] ?? self::DEFAULT_CURRENT_PAGE;
        $maximumResults = $queryParameters['per_page'] ?? self::DEFAULT_ITEMS_PER_PAGE;

        return new self($currentPage, $maximumResults);
    }
}
