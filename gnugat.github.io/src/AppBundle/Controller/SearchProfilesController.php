<?php
// File: src/AppBundle/Controller/SearchProfilesController.php
// Source: https://gnugat.github.io/2016/05/18/towards-cqrs-search-engine.html
// Phase: P2

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Search\Criteria;

class SearchProfilesController extends Controller
{
    /**
     * @Route("/api/v1/profiles")
     * @Method({"GET"})
     */
    public function searchProfilesAction(Request $request)
    {
        $criteria = Criteria::fromQueryParameters(
            'profile',
            $request->query->all()
        );
        $page = $this->get('app.search_engine')->match($criteria)->take(
            $criteria->paginating->offset,
            $criteria->paginating->itemsPerPage
        );
        $totalElements = $page->totalCount();
        $totalPages = (int) ceil($totalElements / $criteria->paginating->itemsPerPage);

        return new JsonResponse(array(
            'items' => iterator_to_array($page->getIterator()),
            'page' => array(
                'current_page' => $criteria->paginating->currentPage,
                'per_page' => $criteria->paginating->itemsPerPage,
                'total_elements' => $totalElements,
                'total_pages' => $totalPages,
            ),
        ), 200);
    }
}
