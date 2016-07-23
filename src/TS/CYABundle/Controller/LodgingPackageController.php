<?php

namespace TS\CYABundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TS\CYABundle\Entity\LodgingPackage;
use TS\CYABundle\Form\LodgingPackageType;

/**
 * LodgingPackage controller.
 *
 * @Route("/lodgingpackage")
 */
class LodgingPackageController extends Controller
{
    /**
     * Lists all LodgingPackage entities.
     *
     * @Route("/", name="lodgingpackage_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lodgingPackages = $em->getRepository('TSCYABundle:LodgingPackage')->findAll();

        return $this->render('lodgingpackage/index.html.twig', array(
            'lodgingPackages' => $lodgingPackages,
        ));
    }

    /**
     * Creates a new LodgingPackage entity.
     *
     * @Route("/new", name="lodgingpackage_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $lodgingPackage = new LodgingPackage();
        $form = $this->createForm('TS\CYABundle\Form\LodgingPackageType', $lodgingPackage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lodgingPackage);
            $em->flush();

            return $this->redirectToRoute('lodgingpackage_show', array('id' => $lodgingPackage->getId()));
        }

        return $this->render('lodgingpackage/new.html.twig', array(
            'lodgingPackage' => $lodgingPackage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a LodgingPackage entity.
     *
     * @Route("/{id}", name="lodgingpackage_show")
     * @Method("GET")
     */
    public function showAction(LodgingPackage $lodgingPackage)
    {
        $deleteForm = $this->createDeleteForm($lodgingPackage);

        return $this->render('lodgingpackage/show.html.twig', array(
            'lodgingPackage' => $lodgingPackage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing LodgingPackage entity.
     *
     * @Route("/{id}/edit", name="lodgingpackage_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, LodgingPackage $lodgingPackage)
    {
        $deleteForm = $this->createDeleteForm($lodgingPackage);
        $editForm = $this->createForm('TS\CYABundle\Form\LodgingPackageType', $lodgingPackage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lodgingPackage);
            $em->flush();

            return $this->redirectToRoute('lodgingpackage_edit', array('id' => $lodgingPackage->getId()));
        }

        return $this->render('lodgingpackage/edit.html.twig', array(
            'lodgingPackage' => $lodgingPackage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a LodgingPackage entity.
     *
     * @Route("/{id}", name="lodgingpackage_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, LodgingPackage $lodgingPackage)
    {
        $form = $this->createDeleteForm($lodgingPackage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lodgingPackage);
            $em->flush();
        }

        return $this->redirectToRoute('lodgingpackage_index');
    }

    /**
     * Creates a form to delete a LodgingPackage entity.
     *
     * @param LodgingPackage $lodgingPackage The LodgingPackage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LodgingPackage $lodgingPackage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lodgingpackage_delete', array('id' => $lodgingPackage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
