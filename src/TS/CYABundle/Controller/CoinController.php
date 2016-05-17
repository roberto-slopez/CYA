<?php

namespace TS\CYABundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TS\CYABundle\Entity\Coin;
use TS\CYABundle\Form\CoinType;

/**
 * Coin controller.
 *
 * @Route("/admin/coin")
 */
class CoinController extends Controller
{
    /**
     * Lists all Coin entities.
     *
     * @Route("/", name="admin_coin_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $coins = $em->getRepository('TSCYABundle:Coin')->findAll();

        return $this->render('coin/index.html.twig', array(
            'coins' => $coins,
        ));
    }

    /**
     * Creates a new Coin entity.
     *
     * @Route("/new", name="admin_coin_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $coin = new Coin();
        $form = $this->createForm('TS\CYABundle\Form\CoinType', $coin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($coin);
            $em->flush();
            $this->get('session')->getFlashBag()->set('exito', 'Registro agregado correctamente');

            return $this->redirectToRoute('admin_coin_show', array('id' => $coin->getId()));
        }

        return $this->render('coin/new.html.twig', array(
            'coin' => $coin,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Coin entity.
     *
     * @Route("/{id}", name="admin_coin_show")
     * @Method("GET")
     */
    public function showAction(Coin $coin)
    {
        $deleteForm = $this->createDeleteForm($coin);

        return $this->render('coin/show.html.twig', array(
            'coin' => $coin,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Coin entity.
     *
     * @Route("/{id}/edit", name="admin_coin_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Coin $coin)
    {
        $deleteForm = $this->createDeleteForm($coin);
        $editForm = $this->createForm('TS\CYABundle\Form\CoinType', $coin);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($coin);
            $em->flush();
            $this->get('session')->getFlashBag()->set('exito', 'Registro editado correctamente');

            return $this->redirectToRoute('admin_coin_edit', array('id' => $coin->getId()));
        }

        return $this->render('coin/edit.html.twig', array(
            'coin' => $coin,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Coin entity.
     *
     * @Route("/{id}", name="admin_coin_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Coin $coin)
    {
        $form = $this->createDeleteForm($coin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($coin);
            $em->flush();
        }

        return $this->redirectToRoute('admin_coin_index');
    }

    /**
     * Creates a form to delete a Coin entity.
     *
     * @param Coin $coin The Coin entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Coin $coin)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_coin_delete', array('id' => $coin->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
