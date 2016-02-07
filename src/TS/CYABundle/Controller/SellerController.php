<?php

namespace TS\CYABundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TS\CYABundle\Entity\Seller;
use TS\CYABundle\Form\SellerType;

/**
 * Seller controller.
 *
 * @Route("/admin/seller")
 */
class SellerController extends Controller
{
    /**
     * Lists all Seller entities.
     *
     * @Route("/", name="admin_seller_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sellers = $em->getRepository('TSCYABundle:Seller')->findAll();

        return $this->render('seller/index.html.twig', array(
            'sellers' => $sellers,
        ));
    }

    /**
     * Creates a new Seller entity.
     *
     * @Route("/new", name="admin_seller_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $seller = new Seller();
        $form = $this->createForm('TS\CYABundle\Form\SellerType', $seller);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($seller);
            $em->flush();

            return $this->redirectToRoute('admin_seller_show', array('id' => $seller->getId()));
        }

        return $this->render('seller/new.html.twig', array(
            'seller' => $seller,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Seller entity.
     *
     * @Route("/{id}", name="admin_seller_show")
     * @Method("GET")
     */
    public function showAction(Seller $seller)
    {
        $deleteForm = $this->createDeleteForm($seller);

        return $this->render('seller/show.html.twig', array(
            'seller' => $seller,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Seller entity.
     *
     * @Route("/{id}/edit", name="admin_seller_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Seller $seller)
    {
        $deleteForm = $this->createDeleteForm($seller);
        $editForm = $this->createForm('TS\CYABundle\Form\SellerType', $seller);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($seller);
            $em->flush();

            return $this->redirectToRoute('admin_seller_edit', array('id' => $seller->getId()));
        }

        return $this->render('seller/edit.html.twig', array(
            'seller' => $seller,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Seller entity.
     *
     * @Route("/{id}", name="admin_seller_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Seller $seller)
    {
        $form = $this->createDeleteForm($seller);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($seller);
            $em->flush();
        }

        return $this->redirectToRoute('admin_seller_index');
    }

    /**
     * Creates a form to delete a Seller entity.
     *
     * @param Seller $seller The Seller entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Seller $seller)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_seller_delete', array('id' => $seller->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
