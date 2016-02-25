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
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $exchangeRateDisable = $em->getRepository('TSCYABundle:ExchangeRateUSD')->getAllExpiration();
        $exchangeRateUSDs = $em->getRepository('TSCYABundle:ExchangeRateUSD')->findBy([
            'enable' => true
        ]);

        foreach ($exchangeRateDisable as $item) {
            $item->setEnable(false);
            $this->saveChangeEntity($item);
        }

        $lodging = $em->getRepository('TSCYABundle:Lodging')->getCount();

        $headquarter = $em->getRepository('TSCYABundle:Headquarter')->getCount();

        $course = $em->getRepository('TSCYABundle:Course')->getCount();

        $package = $em->getRepository('TSCYABundle:Package')->getCount();

        $exchangeRate = $em->getRepository('TSCYABundle:ExchangeRateUSD')
            ->getExchangeRateCount();

        $coin = $em->getRepository('TSCYABundle:Coin')->getCount('USD');

        if (intval($exchangeRate) < intval($coin) ) {
            if (intval($exchangeRate) == 0) {
                $this->setFlashError('¡No hay ninguna tasa de cambio, ingresada para hoy!');
            } else {
                $this->setFlashAviso(
                    sprintf('¡Aún faltan tasas de cambio por ingresar %s/%s!', (string)$exchangeRate, (string)$coin)
                );
            }
        } else {
            $this->setFlashInfo('Todas las tasas de cambio estan actualizadas');
        }

        return [
            'lodgings' => $lodging,
            'headquarters' => $headquarter,
            'courses' => $course,
            'packages' => $package,
            'exchangeRateUSDs' => $exchangeRateUSDs,
        ];
    }

    /**
     * @Route("/cities", name="select_cities", options={"expose"=true})
     * @Method("POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function citiesAction(Request $request)
    {
        $countryId = $request->request->get('countryId');
        $em = $this->getDoctrine()->getManager();
        $cities = $em->getRepository('TSCYABundle:City')->getByCountry($countryId);

        return new JsonResponse($cities);
    }

    /**
     * @Route("/headquarters", name="select_headquarters", options={"expose"=true})
     * @Method("POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function headquarterAction(Request $request)
    {
        $cityId = $request->request->get('cityId');
        $em = $this->getDoctrine()->getManager();
        $cities = $em->getRepository('TSCYABundle:Headquarter')->getByCity($cityId);

        return new JsonResponse($cities);
    }

    /**
     * @Route("/services", name="select_services", options={"expose"=true})
     * @Method("POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function serviceAction(Request $request)
    {
        $headquarterId = $request->request->get('headquarterId');
        $em = $this->getDoctrine()->getManager();
        $services = $em->getRepository('TSCYABundle:Service')->getByHeadquarter($headquarterId);

        return new JsonResponse($services);
    }

    /**
     * @Route("/courses", name="select_courses", options={"expose"=true})
     * @Method("POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function courseAction(Request $request)
    {
        $headquarterId = $request->request->get('headquarterId');
        $em = $this->getDoctrine()->getManager();
        $courses = $em->getRepository('TSCYABundle:Course')->getByHeadquarter($headquarterId);

        return new JsonResponse($courses);
    }

    /**
     * @Route("/lodgings", name="select_lodgings", options={"expose"=true})
     * @Method("POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function lodgingAction(Request $request)
    {
        $headquarterId = $request->request->get('headquarterId');
        $em = $this->getDoctrine()->getManager();
        $lodging = $em->getRepository('TSCYABundle:Lodging')->getByHeadquarter($headquarterId);
        $headquarter = $em->getRepository('TSCYABundle:Headquarter')->find($headquarterId);

        $lodging[0]['headquarter_name'] = $headquarter->getName();

        return new JsonResponse($lodging);
    }

    /**
     * @Route("/packages", name="select_packages", options={"expose"=true})
     * @Method("POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function packageAction(Request $request)
    {
        $headquarterId = $request->request->get('headquarterId');
        $em = $this->getDoctrine()->getManager();
        $lodging = $em->getRepository('TSCYABundle:Package')->getByHeadquarter($headquarterId);

        return new JsonResponse($lodging);
    }

    /**
     * @Route("/exams", name="select_exams", options={"expose"=true})
     * @Method("POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function examAction(Request $request)
    {
        $headquarterId = $request->request->get('headquarterId');
        $em = $this->getDoctrine()->getManager();
        $lodging = $em->getRepository('TSCYABundle:Exam')->getByHeadquarter($headquarterId);

        return new JsonResponse($lodging);
    }
}
