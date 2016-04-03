<?php

namespace TS\CYABundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
Sensio\Bundle\FrameworkExtraBundle\Configuration\Security,
Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use TS\CYABundle\Entity\Exam;
use TS\CYABundle\Entity\Package;
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
        try {
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

                return $this->redirectToRoute('preview_invoice', ['id' => $quotation->getId()]);
            }

        } catch (\Exception $e) {
            $this->setFlashError(sprintf("Error: %s", $e->getMessage()));

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

        try {
            $parameter = trim($request->get('name'));
            if ($parameter == '' ||  !$parameter) {
                $name = false;
                $last = false;
            } else {
                $result = explode(' ', $parameter);
                $name = array_key_exists(0,$result) ? $result[0]: false;
                $last = array_key_exists(1, $result) ? $result[1]: false;
            }

            $em = $this->getDoctrine()->getManager();
            $user = $this->getCurrenUser();
            $userRole = $user->hasRole('ROLE_SUPER_ADMIN') || $user->hasRole('ROLE_ADMIN') ? false : $user->getId();
            $quotations = $em->getRepository('TSCYABundle:Quotation')->getByNameAndLastName($name, $last, $userRole);
        } catch (\Exception $e) {
            $this->setFlashError('Sin resultados');

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
    * @Route("/services/package/filter", name="services_and_package", options={"expose"=true})
    * @Method("POST")
    *
    * @param Request $request
    * @return JsonResponse
    */
    public function ServicesAndPackagection(Request $request)
    {
        $package = $request->request->get('package');
        $services = $request->request->get('services');
        $em = $this->getDoctrine()->getManager();
        $total = 0;

        $package = $em->getRepository('TSCYABundle:Package')->find($package);
        if ($package) {
            $weeks = $package->getSemanas();
            foreach ($services as $service) {
                $result = $em->getRepository('TSCYABundle:Service')->find($service);
                $total += $result->getPrice();
            }
            $total = $weeks * $total;
        }

        return new JsonResponse(number_format($total, 2, '.', ','));
    }

    /**
    * @Route("/examn/{id}/{weeks}", name="exam_by_id", options={"expose"=true})
    * @ParamConverter("id", class="\TS\CYABundle\Entity\Exam")
    * @Method("GET")
    *
    * @param Exam $exam
    * @param $weeks
    * @return JsonResponse
    */
    public function examByIdAction(Exam $exam, $weeks)
    {
        foreach ($exam->getExamRangeWeeks() as $examRangeWeek) {
            $price = $examRangeWeek->isThisRange($weeks);
            if ($price) {
                return new JsonResponse(number_format($price * $weeks, 2, '.', ','));
            }
        }

        return new JsonResponse(0);
    }

    /**
    * @Route("/package/{id}", name="package_by_id", options={"expose"=true})
    * @ParamConverter("id", class="\TS\CYABundle\Entity\Package")
    * @Method("GET")
    *
    * @param Package $package
    * @return JsonResponse
    */
    public function packageByIdAction(Package $package)
    {
        return new JsonResponse(number_format($package->getPrice(), 2, '.', ','));
    }

    /**
    * @Route("/lodging/{id}/{weeks}/{package}", defaults={"package" = "0"}, name="lodging_by_id", options={"expose"=true})
    * @ParamConverter("id", class="\TS\CYABundle\Entity\Lodging")
    * @Method("GET")
    *
    * @param Lodging $lodging
    * @param $weeks
    * @param Package $package
    * @return JsonResponse
    */
    public function lodgingByIdAction(Lodging $lodging, $weeks, $package)
    {
        $priceLodging = $weeks * $lodging->getPricePerWeek();
        if ($package) {
            $em = $this->getDoctrine()->getManager();
            $package = $em->getRepository('TSCYABundle:Package')->find($package);
            foreach ($package->getPackageLodging() as $item) {
                $idLodging = $item->getLodging()->getId();
                if ($idLodging === $lodging->getId()) {
                    $priceLodging = $item->getLodgingPrice();
                    break;
                }
            }
            if (!($priceLodging > 0)) {
                $priceLodging = $package->getSemanas() * $lodging->getPricePerWeek();
            }
        }

        return new JsonResponse(number_format($priceLodging, 2, '.', ','));
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
        if (is_array($services) || is_object($services)) {
            foreach ($services as $service) {
                $result = $em->getRepository('TSCYABundle:Service')->find($service);
                $total += $result->getPrice();
            }
        }

        return new JsonResponse(number_format($weeks * $total, 2, '.', ','));
    }

    /**
     * @Route("/course/promotion/valor", name="current_promotion_course", options={"expose"=true})
     * @Method("POST")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getCurrentPromotion(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $promotion = $em->getRepository('TSCYABundle:Promocion')->getPromotion($request->get('id'));

        return new JsonResponse($promotion);
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
        $exam = $request->request->get('exam');
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

        $totalCourse = 0;
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

        $totalExam = 0;
        if ($exam) {
            $examResult = $em->getRepository('TSCYABundle:Exam')->find($exam);
            foreach ($examResult->getExamRangeWeeks() as $examRangeWeek) {
                $price = $examRangeWeek->isThisRange($weeks);
                if ($price) {
                    $totalExam = $price * $weeks;
                    break;
                }
            }
        }
        if ($lodging) {
            $lodgingResult = $em->getRepository('TSCYABundle:Lodging')->find($lodging);
            $totalLodging = $lodgingResult->getPricePerWeek() * $weeks;
        }

        $response = [
            "exam" => number_format($weeks * $totalExam, 2, '.', ','),
            "course" => number_format($weeks * $totalCourse, 2, '.', ','),
            "lodging" => number_format($weeks * $totalLodging, 2, '.', ','),
            "services" => number_format($weeks * $totalService, 2, '.', ','),
        ];

        return new JsonResponse($response);
    }
}
