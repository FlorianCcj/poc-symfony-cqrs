<?php
// File: src/AppBundle/DoctrineSearch/IteratorPage.php;
// Source: https://gnugat.github.io/2016/05/18/towards-cqrs-search-engine.html
// Phase: P2

namespace AppBundle\DoctrineSearch;

use Porpaginas\Page;

class IteratorPage implements Page
{
    private $iterator;
    private $offset;
    private $limit;
    private $totalCount;

    public function __construct(\Iterator $iterator, int $offset, int $limit, int $totalCount)
    {
        $this->iterator = $iterator;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->totalCount = $totalCount;
    }

    public function getCurrentOffset()
    {
        return $this->offset;
    }

    public function getCurrentPage()
    {
        if (0 === $this->limit) {
            return 1;
        }

        return floor($this->offset / $this->limit) + 1;
    }

    public function getCurrentLimit()
    {
        return $this->limit;
    }

    public function count()
    {
        return count($this->iterator);
    }

    public function totalCount()
    {
        return $this->totalCount;
    }

    public function getIterator()
    {
        return $this->iterator;
    }
}
