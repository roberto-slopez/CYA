<?php

namespace TS\CYABundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Security,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TS\CYABundle\Entity\Client;
use TS\CYABundle\Entity\Course;
use TS\CYABundle\Entity\Service;
use TS\CYABundle\Entity\DiscretionarySpending;
use TS\CYABundle\Entity\Lodging;
use TS\CYABundle\Entity\Quotation;
use TS\CYABundle\Form\QuotationExamType;
use TS\CYABundle\Form\QuotationPackageType;
use TS\CYABundle\Form\QuotationType;

/**
 * Class CotizadorController
 * @package TS\CYABundle\Controller
 *
 * @Route("/cotizador")
 */
class CotizadorController extends BaseController
{
    /**
     * @Route("/", name="cotizador_index")
     * @Template()
     * @Method("GET")
     *
     * @return array
     */
    public function indexAction()
    {
        $quotations = $this->getDoctrine()->getManager()
            ->getRepository('TSCYABundle:Quotation')
            ->getLastRecords(10);

        return [
            'quotations' => $quotations,
        ];
    }

    /**
     * @Route("/flexible/new", name="cotizador_flexible_new")
     * @Template()
     *
     * @param Request $request
     * @return array
     */
    public function newFlexibleAction(Request $request)
    {
        $user = $this->getCurrenUser();

        $seller = $this->getDoctrine()
            ->getManager()
            ->getRepository('TSCYABundle:Seller')
            ->getByUser($user->getId());

        $quotation = new Quotation();
        $quotation->setClient(new Client());
        $quotation->setSeller($seller);
        $quotation->setType(Quotation::FLEXIBLE);

        $form = $this->createForm(QuotationType::class, $quotation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quotation = $this->calculateValues($quotation, Quotation::FLEXIBLE);
            $em = $this->getDoctrine()->getManager();
            $em->persist($quotation);
            $em->flush();
            $this->setFlashInfo('Registro agregado correctamente');

            return $this->redirectToRoute('preview_invoice', ['id' => $quotation->getId()]);
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/paquete/new", name="cotizador_paquete_new")
     * @Template()
     *
     * @param Request $request
     * @return array
     */
    public function newPaqueteAction(Request $request)
    {
        try {
            $user = $this->getCurrenUser();

            $seller = $this->getDoctrine()
                ->getManager()
                ->getRepository('TSCYABundle:Seller')
                ->getByUser($user->getId());

            $quotation = new Quotation();
            $quotation->setClient(new Client());
            $quotation->setSeller($seller);
            $quotation->setType(Quotation::PACKAGE);

            $form = $this->createForm(QuotationPackageType::class, $quotation);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $quotation = $this->calculateValues($quotation, Quotation::PACKAGE);
                $em = $this->getDoctrine()->getManager();
                $em->persist($quotation);
                $em->flush();

                $this->setFlashInfo('Registro agregado correctamente');

                return $this->redirectToRoute('preview_invoice', ['id' => $quotation->getId()]);
            }
        } catch (\Exception $e) {
            $this->setFlashError(sprintf("Error: %s", $e->getMessage()));
            $this->setFlashInfo('Registro agregado correctamente');

            return $this->redirectToRoute('main');
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/examen/new", name="cotizador_examen_new")
     * @Template()
     *
     * @param Request $request
     * @return array
     */
    public function newExamenAction(Request $request)
    {
        $user = $this->getCurrenUser();

        $seller = $this->getDoctrine()
            ->getManager()
            ->getRepository('TSCYABundle:Seller')
            ->getByUser($user->getId());

        $quotation = new Quotation();
        $quotation->setClient(new Client());
        $quotation->setSeller($seller);
        $quotation->setType(Quotation::EXAM);

        $form = $this->createForm(QuotationExamType::class, $quotation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quotation = $this->calculateValues($quotation, Quotation::EXAM);
            $em = $this->getDoctrine()->getManager();
            $em->persist($quotation);
            $em->flush();

            $this->setFlashInfo('Registro agregado correctamente');

            return $this->redirectToRoute('main');
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/search", name="search_cotizacion")
     * @Method({"GET", "POST"})
     * @Template()
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resultSearchAction(Request $request)
    {
        $result = explode(' ', $request->get('name'));
        try {
            $name = $result[0];
            $last = $result[1];
            $em = $this->getDoctrine()->getManager();
            $quotations = $em->getRepository('TSCYABundle:Quotation')->getByNameAndLastName($name, $last);
        } catch (\Exception $e) {
            $this->setFlashError($e->getMessage());

            return $this->redirectToRoute('main');
        }

        return [
            'quotations' => $quotations,
        ];
    }

    /**
     * @Route("/course/{id}/{weeks}", name="course_by_id", options={"expose"=true})
     * @ParamConverter("id", class="\TS\CYABundle\Entity\Course")
     * @Method("GET")
     *
     * @param Course $course
     * @param $weeks
     * @return JsonResponse
     */
    public function courseByIdAction(Course $course, $weeks)
    {
        foreach ($course->getCourseRangeWeeks() as $courseRangeWeek) {
            $price = $courseRangeWeek->isThisRange($weeks);
            if ($price) {
                return new JsonResponse(number_format($price * $weeks, 2, '.', ','));
            }
        }

        return new JsonResponse(0);
    }

    /**
     * @Route("/lodging/{id}/{weeks}", name="lodging_by_id", options={"expose"=true})
     * @ParamConverter("id", class="\TS\CYABundle\Entity\Lodging")
     * @Method("GET")
     *
     * @param Lodging $lodging
     * @param $weeks
     * @return JsonResponse
     */
    public function lodgingByIdAction(Lodging $lodging, $weeks)
    {
        return new JsonResponse(number_format($weeks * $lodging->getPricePerWeek(), 2, '.', ','));
    }

    /**
     * @Route("/services/filter", name="services_by_id", options={"expose"=true})
     * @Method("POST")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function ServicesByIdAction(Request $request)
    {
        $weeks = $request->request->get('weeks');
        $services = $request->request->get('services');
        $em = $this->getDoctrine()->getManager();

        $total = 0;

        foreach ($services as $service) {
            $result = $em->getRepository('TSCYABundle:Service')->find($service);
            $total += $result->getPrice();
        }

        return new JsonResponse(number_format($weeks * $total, 2, '.', ','));
    }

    /**
     * @Route("/weeks/change", name="weekschange", options={"expose"=true})
     * @Method("POST")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function changeWeeksAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $weeks = $request->request->get('weeks');
        $services = $request->request->get('services');
        $course = $request->request->get('course');
        $lodging = $request->request->get('lodging');

        $totalService = 0;
        $totalLodging = 0;
        $totalCourse = 0;

        if ($services) {
            foreach ($services as $service) {
                $result = $em->getRepository('TSCYABundle:Service')->find($service);
                $totalService += $result->getPrice();
            }

            $totalService = $totalService * $weeks;
        }

        if ($course) {
            $courseResult = $em->getRepository('TSCYABundle:Course')->find($course);
            foreach ($courseResult->getCourseRangeWeeks() as $courseRangeWeek) {
                $price = $courseRangeWeek->isThisRange($weeks);
                if ($price) {
                    $totalCourse = $price * $weeks;
                    break;
                }
            }
        }

        if ($lodging) {
            $lodgingResult = $em->getRepository('TSCYABundle:Lodging')->find($lodging);
            $totalLodging = $lodgingResult->getPricePerWeek() * $weeks;
        }

        $response = [
            "course" => number_format($weeks * $totalCourse, 2, '.', ','),
            "lodging" => number_format($weeks * $totalLodging, 2, '.', ','),
            "services" => number_format($weeks * $totalService, 2, '.', ','),
        ];

        return new JsonResponse($response);
    }
}
