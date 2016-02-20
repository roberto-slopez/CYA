<?php

namespace TS\CYABundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Security,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use TS\CYABundle\Entity\Client;
use TS\CYABundle\Entity\DiscretionarySpending;
use TS\CYABundle\Entity\Quotation;
use TS\CYABundle\Form\QuotationType;

/**
 * Class CotizadorFlexibleController
 * @package TS\CYABundle\Controller
 *
 * @Route("/admin/cotizador/flexible")
 */
class CotizadorFlexibleController extends BaseController
{
    /**
     * @Route("/", name="cotizador_flexible_index")
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
     * @Route("/new", name="cotizador_flexible_new")
     * @Template()
     *
     * @param Request $request
     * @return array
     */
    public function newAction(Request $request)
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

        if ($form->isSubmitted()) {
            \ChromePhp::info($quotation->getLodging());
            $quotation = $this->calculateValues($quotation, Quotation::FLEXIBLE);
            \ChromePhp::info($quotation);

            /*$em = $this->getDoctrine()->getManager();
            $em->persist($quotation);
            $em->flush();*/
/*
            $this->setFlashAviso('Registro agregado correctamente');

            return $this->redirectToRoute('cotizador_flexible_index');*/
        }

        return [
            'form' => $form->createView(),
        ];
    }
}
