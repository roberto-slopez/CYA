<?php

namespace TS\CYABundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TS\CYABundle\Entity\DiscretionarySpending;
use TS\CYABundle\Form\DiscretionarySpendingType;

/**
 * DiscretionarySpending controller.
 *
 * @Route("/admin/discretionaryspending")
 */
class DiscretionarySpendingController extends Controller
{
    /**
     * Lists all DiscretionarySpending entities.
     *
     * @Route("/", name="admin_discretionaryspending_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $discretionarySpendings = $em->getRepository('TSCYABundle:DiscretionarySpending')->findAll();

        return $this->render('discretionaryspending/index.html.twig', array(
            'discretionarySpendings' => $discretionarySpendings,
        ));
    }

    /**
     * Creates a new DiscretionarySpending entity.
     *
     * @Route("/new", name="admin_discretionaryspending_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $discretionarySpending = new DiscretionarySpending();
        $form = $this->createForm('TS\CYABundle\Form\DiscretionarySpendingType', $discretionarySpending);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($discretionarySpending);
            $em->flush();
            $this->get('session')->getFlashBag()->set('exito', 'Registro agregado correctamente');

            return $this->redirectToRoute('admin_discretionaryspending_show', array('id' => $discretionarySpending->getId()));
        }

        return $this->render('discretionaryspending/new.html.twig', array(
            'discretionarySpending' => $discretionarySpending,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DiscretionarySpending entity.
     *
     * @Route("/{id}", name="admin_discretionaryspending_show")
     * @Method("GET")
     */
    public function showAction(DiscretionarySpending $discretionarySpending)
    {
        $deleteForm = $this->createDeleteForm($discretionarySpending);

        return $this->render('discretionaryspending/show.html.twig', array(
            'discretionarySpending' => $discretionarySpending,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DiscretionarySpending entity.
     *
     * @Route("/{id}/edit", name="admin_discretionaryspending_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, DiscretionarySpending $discretionarySpending)
    {
        $deleteForm = $this->createDeleteForm($discretionarySpending);
        $editForm = $this->createForm('TS\CYABundle\Form\DiscretionarySpendingType', $discretionarySpending);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($discretionarySpending);
            $em->flush();
            $this->get('session')->getFlashBag()->set('exito', 'Registro editado correctamente');

            return $this->redirectToRoute('admin_discretionaryspending_edit', array('id' => $discretionarySpending->getId()));
        }

        return $this->render('discretionaryspending/edit.html.twig', array(
            'discretionarySpending' => $discretionarySpending,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a DiscretionarySpending entity.
     *
     * @Route("/{id}", name="admin_discretionaryspending_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, DiscretionarySpending $discretionarySpending)
    {
        $form = $this->createDeleteForm($discretionarySpending);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($discretionarySpending);
            $em->flush();
        }

        return $this->redirectToRoute('admin_discretionaryspending_index');
    }

    /**
     * Creates a form to delete a DiscretionarySpending entity.
     *
     * @param DiscretionarySpending $discretionarySpending The DiscretionarySpending entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DiscretionarySpending $discretionarySpending)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_discretionaryspending_delete', array('id' => $discretionarySpending->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
