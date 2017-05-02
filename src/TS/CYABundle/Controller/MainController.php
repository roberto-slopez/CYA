<?php

namespace TS\CYABundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Security,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TS\CYABundle\Entity\Coin;
use TS\CYABundle\Entity\Country;
use TS\CYABundle\Entity\Quotation;
use TS\CYABundle\Form\AgencyType;

/**
 * @Security("has_role('ROLE_USER')")
 */
class MainController extends BaseController
{
    /**
     * @Route("/redirec/to/dashboard", name="fos_user_profile_show")
     */
    public function redirectToDashboard () {
        return $this->redirectToRoute('main');
    }

    /**
     * @Route("/", name="main")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $exchangeRateDisable = $em->getRepository('TSCYABundle:ExchangeRateUSD')->getAllExpiration();

        foreach ($exchangeRateDisable as $item) {
            $item->setEnable(false);
            $this->saveChangeEntity($item);
        }

        $exchangeRateUSDs = $em->getRepository('TSCYABundle:ExchangeRateUSD')->findBy(['enable' => true]);

        $exchangeRateToExpire = $this->validExpirationDate($exchangeRateUSDs);

        $lodging = $em->getRepository('TSCYABundle:Lodging')->getCount();

        $headquarter = $em->getRepository('TSCYABundle:Headquarter')->getCount();

        $course = $em->getRepository('TSCYABundle:Course')->getCount();

        $exam = $em->getRepository('TSCYABundle:Exam')->getCount();

        return [
            'lodgings' => $lodging,
            'exams' => $exam,
            'headquarters' => $headquarter,
            'courses' => $course,
            'exchangeRateUSDs' => $exchangeRateUSDs,
            'exchangeRateToExpire' => $exchangeRateToExpire,
            'exchangeRateToExpireCount' => count($exchangeRateToExpire)
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
     * @Route("/promocions", name="select_promocions", options={"expose"=true})
     * @Method("POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function promocionsAction(Request $request)
    {
        $courseId = $request->request->get('courseId');
        $em = $this->getDoctrine()->getManager();
        $promocions = $em->getRepository('TSCYABundle:Promocion')->getByCourse($courseId);

        return new JsonResponse($promocions);
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
     * @Route("/lodgings/package/all", name="select_lodgings_package", options={"expose"=true})
     * @Method("POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function lodgingPackageAction(Request $request)
    {
        $headquarterId = $request->request->get('headquarterId');
        $em = $this->getDoctrine()->getManager();
        $lodging = $em->getRepository('TSCYABundle:LodgingPackage')->getByHeadquarter($headquarterId);

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

    /**
     * @Route("/discretionary_spending", name="select_discretionary_spendings", options={"expose"=true})
     * @Method("POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function discretionarySpendingAction(Request $request)
    {
        $countryId = $request->request->get('countryId');
        $em = $this->getDoctrine()->getManager();
        $discretionarySpending = $em->getRepository('TSCYABundle:DiscretionarySpending')->getByCountry($countryId);

        return new JsonResponse($discretionarySpending);
    }

    /**
     * @Route("/country/{id}/coin", name="country_id_coin", options={"expose"=true})
     * @Method("GET")
     * @ParamConverter("id", class="\TS\CYABundle\Entity\Country")
     *
     * @param Country $country
     * @return JsonResponse
     */
    public function coinSimbolByIdAction(Country $country)
    {
        $coin = $country->getCoin();

        return new JsonResponse($coin->getCode().' '.$coin->getSymbol());
    }

    /**
     * @Route("/invoice/pdf/{id}", name="to_pdf_invoice")
     * @ParamConverter("id", class="\TS\CYABundle\Entity\Quotation")
     *
     * @param Quotation $quotation
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function invoiceToPDFAction(Quotation $quotation)
    {
        $html = $this->renderView('@TSCYA/Main/invoice.html.twig', ['quotation' => $quotation]);
        $client = $quotation->getClient();
        $namePDF = sprintf(
            '%s_%s_%s_%s',
            $client->getFirstName(),
            $client->getLastName(),
            $quotation->getSemanas(),
            $quotation->getHeadquarter()->getName()
        );

        $attachment = sprintf('attachment; filename="%s.pdf"', $namePDF); // Nombre, número de semanas y sede
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => $attachment,
            )
        );
    }

    /**
     * @Route("/invoice/preview/{id}", name="preview_invoice")
     * @ParamConverter("id", class="\TS\CYABundle\Entity\Quotation")
     * @Template()
     *
     * @param Quotation $quotation
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function invoicePreviewAction(Quotation $quotation)
    {
        $agency = $this->getDoctrine()
            ->getManager()
            ->getRepository('TSCYABundle:Agency')
            ->find($this->getParameter('agency'));

        return [
            'quotation' => $quotation,
            'agency' => $agency
        ];
    }


    /**
     * @Route("/agency/current", name="agency_current")
     * @Template()
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @return array
     */
    public function agencyAction(Request $request)
    {
        $agency = $this->getDoctrine()
            ->getManager()
            ->getRepository('TSCYABundle:Agency')
            ->find($this->getParameter('agency'));

        $form = $this->createForm(AgencyType::class, $agency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($agency);
            $em->flush();
            $this->setFlashInfo('Datos actualizados correctamente');
        }

        return [
            'form' => $form->createView(),
        ];
    }
}
