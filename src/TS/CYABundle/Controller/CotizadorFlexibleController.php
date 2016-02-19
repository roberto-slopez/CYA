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
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @return array
     */
    public function newAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $seller = $this->getDoctrine()
            ->getManager()
            ->getRepository('TSCYABundle:Seller')
            ->getByUser($user->getId());

        $quotation = new Quotation();
        $quotation->setClient(new Client());
        //$quotation->addDiscretionarySpending(new DiscretionarySpending());
        $quotation->setSeller($seller);
        $quotation->setType(Quotation::FLEXIBLE);

        $form = $this->createForm(QuotationType::class, $quotation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($quotation);
            $em->flush();

            $this->setFlashAviso('Registro agregado correctamente');

            return $this->redirectToRoute('cotizador_flexible_index');
        }

        return [
            'form' => $form->createView(),
        ];
    }
}
