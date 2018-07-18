<?php
// File: src/AppBundle/Controller/ProfileCreationController.php;
// Source: https://gnugat.github.io/2016/05/11/towards-cqrs-command-bus.html
// Phase: P1

namespace AppBundle\Controller;

use AppBundle\Entity\Profile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProfileCreationController extends Controller
{
    /**
     * @Route("/api/v1/profiles")
     * @Method({"POST"})
     * 
     * Note: Exceptions could be handled in an event listener.
     */
    public function createProfileAction(Request $request)
    {
        try {
            $createdProfile = $this->get('command_bus')->handle(new CreateNewProfile(
                $request->request->get('name')
            ));
        } catch (\DomainException $e) {
            return new JsonResponse(array('error' => $e->getMessage()), 422);
        }

        return new JsonResponse($createdProfile->toArray(), 201);
    }
}
