<?php
// File: src/AppBundle/Search/SearchEngine.php;
// Source: https://gnugat.github.io/2016/05/18/towards-cqrs-search-engine.html
// Phase: P2

namespace AppBundle\Search;

use Porpaginas\Result;

/*
 * Note: We're using porpaginas, a library that makes paginated result a breeze to handle. Find out more about it here.
 *
 * A Criteria is a value object, composed of:
 *
 *  a resource name (e.g. profile)
 *  a Paginating value object
 *  an Ordering value object
 *  a Filtering value object
 * 
 */
interface SearchEngine
{
    public function match(Criteria $criteria) : Result;
}