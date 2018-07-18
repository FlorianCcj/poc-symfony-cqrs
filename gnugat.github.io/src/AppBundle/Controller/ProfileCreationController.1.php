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
     */
    public function createProfileV1Action(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $name = $request->request->get('name');
        if (null === $name) {
            return new JsonResponse(array('error' => 'The "name" parameter is missing from the request\'s body'), 422);
        }
        if (null !== $em->getRepository('AppBundle:Profile')->findOneByName($name)) {
            return new JsonResponse(array('error' => 'The name "'.$name.'" is already taken'), 422);
        }
        $createdProfile = new Profile($name);
        $em->persist($createdProfile);
        $em->flush();

        return new JsonResponse($createdProfile->toArray(), 201);
    }
}
