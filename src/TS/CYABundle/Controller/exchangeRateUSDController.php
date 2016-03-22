<?php

namespace TS\CYABundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TS\CYABundle\Entity\ExchangeRateUSD;
use TS\CYABundle\Form\exchangeRateUSDType;

/**
 * exchangeRateUSD controller.
 *
 * @Route("/admin/exchangeRateUSD")
 */
class exchangeRateUSDController extends Controller
{
    /**
     * Lists all exchangeRateUSD entities.
     *
     * @Route("/", name="admin_exchangeRateUSD_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $exchangeRateUSDs = $em->getRepository('TSCYABundle:ExchangeRateUSD')->findBy([
            'enable' => true
        ]);

        return $this->render('exchangerateusd/index.html.twig', array(
            'exchangeRateUSDs' => $exchangeRateUSDs,
        ));
    }

    /**
     * Creates a new exchangeRateUSD entity.
     *
     * @Route("/new", name="admin_exchangeRateUSD_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $exchangeRateUSD = new ExchangeRateUSD();
        $exchangeRateUSD->setDate(new \DateTime('today'));
        $exchangeRateUSD->setExpiration(new \DateTime('today'));

        $form = $this->createForm('TS\CYABundle\Form\exchangeRateUSDType', $exchangeRateUSD);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($exchangeRateUSD);
            $em->flush();

            return $this->redirectToRoute('admin_exchangeRateUSD_show', array('id' => $exchangeRateUSD->getId()));
        }

        return $this->render('exchangerateusd/new.html.twig', array(
            'exchangeRateUSD' => $exchangeRateUSD,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a exchangeRateUSD entity.
     *
     * @Route("/{id}", name="admin_exchangeRateUSD_show")
     * @Method("GET")
     */
    public function showAction(exchangeRateUSD $exchangeRateUSD)
    {
        $deleteForm = $this->createDeleteForm($exchangeRateUSD);

        return $this->render('exchangerateusd/show.html.twig', array(
            'exchangeRateUSD' => $exchangeRateUSD,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing exchangeRateUSD entity.
     *
     * @Route("/{id}/edit", name="admin_exchangeRateUSD_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, exchangeRateUSD $exchangeRateUSD)
    {
        $deleteForm = $this->createDeleteForm($exchangeRateUSD);
        $editForm = $this->createForm('TS\CYABundle\Form\exchangeRateUSDType', $exchangeRateUSD);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($exchangeRateUSD);
            $em->flush();

            return $this->redirectToRoute('admin_exchangeRateUSD_edit', array('id' => $exchangeRateUSD->getId()));
        }

        return $this->render('exchangerateusd/edit.html.twig', array(
            'exchangeRateUSD' => $exchangeRateUSD,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a exchangeRateUSD entity.
     *
     * @Route("/{id}", name="admin_exchangeRateUSD_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, exchangeRateUSD $exchangeRateUSD)
    {
        $form = $this->createDeleteForm($exchangeRateUSD);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($exchangeRateUSD);
            $em->flush();
        }

        return $this->redirectToRoute('admin_exchangeRateUSD_index');
    }

    /**
     * Creates a form to delete a exchangeRateUSD entity.
     *
     * @param exchangeRateUSD $exchangeRateUSD The exchangeRateUSD entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(exchangeRateUSD $exchangeRateUSD)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_exchangeRateUSD_delete', array('id' => $exchangeRateUSD->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
