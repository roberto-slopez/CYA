<?php

namespace TS\CYABundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Security,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_USER')")
 */
class MainController extends BaseController
{
    /**
     * @Route("/", name="main")
     * @Template()
     */
    public function indexAction()
    {
        return [
        ];
    }

    /**
     * @Route("/cities", name="select_cities", options={"expose"=true})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function citiesAction(Request $request)
    {
        $countryId = $request->request->get('countryId');
        $em = $this->getDoctrine()->getManager();
        $cities = $em->getRepository('TSCYABundle:City')->findAll();

        return new JsonResponse($cities);
    }
}
