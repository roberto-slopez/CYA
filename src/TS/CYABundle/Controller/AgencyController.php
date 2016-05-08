<?php

namespace TS\CYABundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TS\CYABundle\Entity\Agency;
use TS\CYABundle\Form\AgencyType;

/**
 * Agency controller.
 *
 * @Route("/admin/agency")
 */
class AgencyController extends Controller
{
    /**
     * Lists all Agency entities.
     *
     * @Route("/", name="agency_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $agencies = $em->getRepository('TSCYABundle:Agency')->findAll();

        return $this->render('agency/index.html.twig', array(
            'agencies' => $agencies,
        ));
    }

    /**
     * Creates a new Agency entity.
     *
     * @Route("/new", name="agency_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $agency = new Agency();
        $form = $this->createForm('TS\CYABundle\Form\AgencyType', $agency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($agency);
            $em->flush();

            return $this->redirectToRoute('agency_show', array('id' => $agency->getId()));
        }

        return $this->render('agency/new.html.twig', array(
            'agency' => $agency,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Agency entity.
     *
     * @Route("/{id}", name="agency_show")
     * @Method("GET")
     */
    public function showAction(Agency $agency)
    {
        $deleteForm = $this->createDeleteForm($agency);

        return $this->render('agency/show.html.twig', array(
            'agency' => $agency,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Agency entity.
     *
     * @Route("/{id}/edit", name="agency_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Agency $agency)
    {
        $deleteForm = $this->createDeleteForm($agency);
        $editForm = $this->createForm('TS\CYABundle\Form\AgencyType', $agency);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($agency);
            $em->flush();

            return $this->redirectToRoute('agency_edit', array('id' => $agency->getId()));
        }

        return $this->render('agency/edit.html.twig', array(
            'agency' => $agency,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Agency entity.
     *
     * @Route("/{id}", name="agency_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Agency $agency)
    {
        $form = $this->createDeleteForm($agency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($agency);
            $em->flush();
        }

        return $this->redirectToRoute('agency_index');
    }

    /**
     * Creates a form to delete a Agency entity.
     *
     * @param Agency $agency The Agency entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Agency $agency)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('agency_delete', array('id' => $agency->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
