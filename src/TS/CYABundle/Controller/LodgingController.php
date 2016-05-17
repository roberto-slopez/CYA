<?php

namespace TS\CYABundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TS\CYABundle\Entity\Lodging;
use TS\CYABundle\Form\LodgingType;

/**
 * Lodging controller.
 *
 * @Route("/admin/lodging")
 */
class LodgingController extends Controller
{
    /**
     * Lists all Lodging entities.
     *
     * @Route("/", name="admin_lodging_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lodgings = $em->getRepository('TSCYABundle:Lodging')->findAll();

        return $this->render('lodging/index.html.twig', array(
            'lodgings' => $lodgings,
        ));
    }

    /**
     * Creates a new Lodging entity.
     *
     * @Route("/new", name="admin_lodging_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $lodging = new Lodging();
        $form = $this->createForm('TS\CYABundle\Form\LodgingType', $lodging);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lodging);
            $em->flush();
            $this->get('session')->getFlashBag()->set('exito', 'Registro agregado correctamente');

            return $this->redirectToRoute('admin_lodging_show', array('id' => $lodging->getId()));
        }

        return $this->render('lodging/new.html.twig', array(
            'lodging' => $lodging,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Lodging entity.
     *
     * @Route("/{id}", name="admin_lodging_show")
     * @Method("GET")
     */
    public function showAction(Lodging $lodging)
    {
        $deleteForm = $this->createDeleteForm($lodging);

        return $this->render('lodging/show.html.twig', array(
            'lodging' => $lodging,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Lodging entity.
     *
     * @Route("/{id}/edit", name="admin_lodging_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Lodging $lodging)
    {
        $deleteForm = $this->createDeleteForm($lodging);
        $editForm = $this->createForm('TS\CYABundle\Form\LodgingType', $lodging);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lodging);
            $em->flush();
            $this->get('session')->getFlashBag()->set('exito', 'Registro editado correctamente');

            return $this->redirectToRoute('admin_lodging_edit', array('id' => $lodging->getId()));
        }

        return $this->render('lodging/edit.html.twig', array(
            'lodging' => $lodging,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Lodging entity.
     *
     * @Route("/{id}", name="admin_lodging_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Lodging $lodging)
    {
        $form = $this->createDeleteForm($lodging);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lodging);
            $em->flush();
        }

        return $this->redirectToRoute('admin_lodging_index');
    }

    /**
     * Creates a form to delete a Lodging entity.
     *
     * @param Lodging $lodging The Lodging entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Lodging $lodging)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_lodging_delete', array('id' => $lodging->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
