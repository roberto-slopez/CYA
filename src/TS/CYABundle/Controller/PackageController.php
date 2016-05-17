<?php

namespace TS\CYABundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TS\CYABundle\Entity\Package;
use TS\CYABundle\Form\PackageType;

/**
 * Package controller.
 *
 * @Route("/admin/package")
 */
class PackageController extends Controller
{
    /**
     * Lists all Package entities.
     *
     * @Route("/", name="admin_package_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $packages = $em->getRepository('TSCYABundle:Package')->findAll();

        return $this->render('package/index.html.twig', array(
            'packages' => $packages,
        ));
    }

    /**
     * Creates a new Package entity.
     *
     * @Route("/new", name="admin_package_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $package = new Package();
        $form = $this->createForm('TS\CYABundle\Form\PackageType', $package);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($package);
            $em->flush();
            $this->get('session')->getFlashBag()->set('exito', 'Registro agregado correctamente');

            return $this->redirectToRoute('admin_package_show', array('id' => $package->getId()));
        }

        return $this->render('package/new.html.twig', array(
            'package' => $package,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Package entity.
     *
     * @Route("/{id}", name="admin_package_show")
     * @Method("GET")
     */
    public function showAction(Package $package)
    {
        $deleteForm = $this->createDeleteForm($package);

        return $this->render('package/show.html.twig', array(
            'package' => $package,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Package entity.
     *
     * @Route("/{id}/edit", name="admin_package_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Package $package)
    {
        $deleteForm = $this->createDeleteForm($package);
        $editForm = $this->createForm('TS\CYABundle\Form\PackageType', $package);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($package);
            $em->flush();
            $this->get('session')->getFlashBag()->set('exito', 'Registro editado correctamente');

            return $this->redirectToRoute('admin_package_edit', array('id' => $package->getId()));
        }

        return $this->render('package/edit.html.twig', array(
            'package' => $package,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Package entity.
     *
     * @Route("/{id}", name="admin_package_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Package $package)
    {
        $form = $this->createDeleteForm($package);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($package);
            $em->flush();
        }

        return $this->redirectToRoute('admin_package_index');
    }

    /**
     * Creates a form to delete a Package entity.
     *
     * @param Package $package The Package entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Package $package)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_package_delete', array('id' => $package->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
