<?php

namespace TS\CYABundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TS\CYABundle\Entity\Country;
use TS\CYABundle\Form\CountryType;

/**
 * Country controller.
 *
 * @Route("/admin/country")
 */
class CountryController extends Controller
{
    /**
     * Lists all Country entities.
     *
     * @Route("/", name="admin_country_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $countries = $em->getRepository('TSCYABundle:Country')->findAll();

        return $this->render('country/index.html.twig', array(
            'countries' => $countries,
        ));
    }

    /**
     * Creates a new Country entity.
     *
     * @Route("/new", name="admin_country_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $country = new Country();
        $form = $this->createForm('TS\CYABundle\Form\CountryType', $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($country);
            $em->flush();
            $this->get('session')->getFlashBag()->set('exito', 'Registro agregado correctamente');

            return $this->redirectToRoute('admin_country_show', array('id' => $country->getId()));
        }

        return $this->render('country/new.html.twig', array(
            'country' => $country,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Country entity.
     *
     * @Route("/{id}", name="admin_country_show")
     * @Method("GET")
     */
    public function showAction(Country $country)
    {
        $deleteForm = $this->createDeleteForm($country);

        return $this->render('country/show.html.twig', array(
            'country' => $country,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Country entity.
     *
     * @Route("/{id}/edit", name="admin_country_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Country $country)
    {
        $deleteForm = $this->createDeleteForm($country);
        $editForm = $this->createForm('TS\CYABundle\Form\CountryType', $country);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($country);
            $em->flush();
            $this->get('session')->getFlashBag()->set('exito', 'Registro editado correctamente');

            return $this->redirectToRoute('admin_country_edit', array('id' => $country->getId()));
        }

        return $this->render('country/edit.html.twig', array(
            'country' => $country,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Country entity.
     *
     * @Route("/{id}", name="admin_country_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Country $country)
    {
        $form = $this->createDeleteForm($country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($country);
            $em->flush();
        }

        return $this->redirectToRoute('admin_country_index');
    }

    /**
     * Creates a form to delete a Country entity.
     *
     * @param Country $country The Country entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Country $country)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_country_delete', array('id' => $country->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
